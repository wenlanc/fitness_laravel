<?php
/**
* FilterEngine.php - Main component file
*
* This file is part of the Filter component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Filter;

use Carbon\Carbon;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;
use App\Yantrana\Components\Review\Repositories\ManageReviewRepository;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Components\UserSetting\UserSettingEngine;
use App\Yantrana\Components\Filter\Interfaces\FilterEngineInterface;
use Request;

class FilterEngine extends BaseEngine implements FilterEngineInterface
{
    /**
     * @var  UserSettingRepository $userSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

    /**
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * @var  UserSettingEngine $userSettingEngine - UserSetting Engine
     */
    protected $userSettingEngine;
    /**
     * @var  ManageReviewRepository $manageReviewRepository - ManageReviewRepository
     */
    protected $manageReviewRepository;
    /**
     * Constructor
     * @param  UserSettingRepository $userSettingRepository - UserSetting Repository
     * @return  void
     *-----------------------------------------------------------------------*/
    function __construct(
        UserSettingRepository $userSettingRepository,
        UserRepository $userRepository,
        UserSettingEngine $userSettingEngine,
        ManageReviewRepository $manageReviewRepository
    ) {
        $this->userSettingRepository = $userSettingRepository;
        $this->userRepository        = $userRepository;
        $this->userSettingEngine     = $userSettingEngine;
        $this->manageReviewRepository        = $manageReviewRepository;
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareApiBasicFilterData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);

        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();

        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge($toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()])));

        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->first_name . ' ' . $filter->last_name,
                    'profileImage'  => $profilePictureUrl,
                    'gender'        => $gender,
                    'dob'           => $filter->dob,
                    'userAge'       => $userAge,
                    'countryName'   => $filter->countryName,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'     => isPremiumUser($filter->user_id),
                    'detailString'  => implode(", ", array_filter([$userAge, $gender]))
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('api.user.find_matches.read.support_data');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        $distanceUnit = 'Miles';
        if (getStoreSettings('distance_measurement') == '6371') {
            $distanceUnit = 'KM';
        }

        $basicFilterData = [
            'looking_for'       => getUserSettings('looking_for'),
            'min_age'           => getUserSettings('min_age'),
            'max_age'           => getUserSettings('max_age'),
            'distance'          => getUserSettings('distance'),
            'genderList'        => configItem('user_settings.gender'),
            'minAgeList'        => configItem('user_settings.age_range'),
            'maxAgeList'        => configItem('user_settings.age_range'),
            'distanceUnit'      => $distanceUnit
        ];

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total(),
            'basicFilterData'        => $basicFilterData
        ]);
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processFilterData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }
        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds))); // $toUserIds,

        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);

        $filterData = $featuredFilterData = [];

        // Checking premium feature as distance within 10 km
        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);
        $userInfo = getUserAuthInfo();
        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro =  $user_role != 'admin' && ( $featurePlanCollection[$user_role]['featured_profile_in_discovery']['select_user'] == 2);
        $hasFeature = ( $isAllowOnlyPro && ($userMembership == "pro" || $userMembership == "premium"));
            
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;


                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                 // Gym setting data
                 $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                 $userGymsData = [];
                 //check if not empty
                 if (!__isEmpty($userGymsCollection)) {
                     foreach ($userGymsCollection as $key => $userGym) {
                         $userGymLogoUrl = '';
                         $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                         $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                         $userGymsData[] = [
                             'userGymLogoUrl' => $userGymLogoUrl,
                             'gymName'           => $userGym->gymName,
                             'gymId'          => $userGym->gymId  
                         ];
                     }
                 }
                 $isFeaturedBadge = false;
                 if($hasFeature){
                    if( calculateDistance($userInfo['profile']['location_latitude'],$userInfo['profile']['location_longitude'],$filter->location_latitude,$filter->location_longitude ,"K") < 10 ) 
                    {
                        $isFeaturedBadge = true;
                    }
                 }
                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'    => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'            => $filter->city,  
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userGymsData'  => $userGymsData,
                    'isFeaturedBadge' => $isFeaturedBadge
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.find_matches');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }
        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    public function processFilterDataDistance($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }
        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['distance'] = 15;
        $inputData['country'] = $userProfile->countries__id;
        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds,  [getUserID()], $adminIds))); //$mutualLikeIds, $toUserIds,

        // Get filter collection data
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount);

        $filterData = $featuredFilterData = [];

        // Checking premium feature as distance within 10 km
        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);
        $userInfo = getUserAuthInfo();
        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro =  $user_role != 'admin' && ( $featurePlanCollection[$user_role]['featured_profile_in_discovery']['select_user'] == 2);
        $hasFeature = ( $isAllowOnlyPro && ($userMembership == "pro" || $userMembership == "premium"));
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;


                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                 // Gym setting data
                 $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                 $userGymsData = [];
                 //check if not empty
                 if (!__isEmpty($userGymsCollection)) {
                     foreach ($userGymsCollection as $key => $userGym) {
                         $userGymLogoUrl = '';
                         $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                         $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                         $userGymsData[] = [
                             'userGymLogoUrl' => $userGymLogoUrl,
                             'gymName'           => $userGym->gymName,
                             'gymId'          => $userGym->gymId  
                         ];
                     }
                 }

                //  $isFeaturedBadge = false;
                //  if($hasFeature){
                //     if( calculateDistance($userInfo['profile']['location_latitude'],$userInfo['profile']['location_longitude'],$filter->location_latitude,$filter->location_longitude ,"K") < 10 ) 
                //     {
                //         $isFeaturedBadge = true;
                //     }
                //  }
                // Prepare data for filter

                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'    => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'            => $filter->city,  
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userGymsData'  => $userGymsData,
                    'isFeaturedBadge' => ( $filter->membership == "pro" || $filter->membership == "premium" )
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.find_matches');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }
        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }


    public function processFilterMatchData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds)));  // $toUserIds

        // Get filter collection data  --- PT user role -> 3
        $filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, $mutualLikeIds, $paginateCount, [2,3] );

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                if( $mutualLike ) {
                    $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                    $profilePictureUrl = noThumbImageURL();
                    // Check if user profile exists
                    if (!__isEmpty($filter)) {
                        if (!__isEmpty($filter->profile_picture)) {
                            $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                        }
                    }
                    $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                    $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                    //fetch like dislike data by to user id
                    $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                    
                    $userLikeData = [];
                    $userLikeDataValue = 0;
                    //check is not empty
                    if (!__isEmpty($likeDislikeData)) {
                        $userLikeData = [
                            '_id' => $likeDislikeData->_id,
                            'like' => $likeDislikeData->like,
                            'mutual' => $mutualLike,
                        ];
                        $userLikeDataValue = $likeDislikeData->like;
                    }
                    $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                    $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                    
                    // Gym setting data
                    $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                    $userGymsData = [];
                    //check if not empty
                    if (!__isEmpty($userGymsCollection)) {
                        foreach ($userGymsCollection as $key => $userGym) {
                            $userGymLogoUrl = '';
                            $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                            $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                            $userGymsData[] = [
                                'userGymLogoUrl' => $userGymLogoUrl,
                                'gymName'           => $userGym->gymName,
                                'gymId'          => $userGym->gymId  
                            ];
                        }
                    }

                    // Prepare data for filter
                    $filterData[] = [
                        'id'            => $filter->user_id,
                        'username'      => $filter->username,
                        'kanji_name'      => $filter->kanji_name,
                        'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                        'about_me'      => $filter->about_me,
                        'profileImage'  => $profilePictureUrl,
                        'gender'         => $gender,
                        'dob'             => $filter->dob,
                        'userAge'        => $userAge,
                        'countryName'     => $filter->countryName,
                        'city'            => $filter->city,  
                        'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                        'isPremiumUser'        => isPremiumUser($filter->user_id),
                        'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                        'likeData'    => $userLikeDataValue,
                        'userAvailability' => $usertime,
                        'totalReviewRate'    => $totalReviewRate,
                        'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                        'userGymsData'   => $userGymsData
                    ];
                }
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.match_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    public function processFilterPendingData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray(); 
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();

        //fetch all user like dislike data
        $getLikeDislikeDataWithoutMutual = $this->userRepository->fetchAllUserLikeDislike()->where('status', 1)->whereNotIn('to_users__id', $mutualLikeIds);
        //pluck to_users_id in array
        $toUserIdsWithoutMutual = $getLikeDislikeDataWithoutMutual->pluck('to_users__id')->toArray();

        //get people likes me data
        $userPendingLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereNotIn('by_users__id', $mutualLikeIds);
        //pluck people like me ids
        $pendingLikeIds = $userPendingLikedMeData->pluck('userId')->toArray();

        $totalIds = array_values(array_unique(array_merge( $pendingLikeIds, $toUserIdsWithoutMutual)));

        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds)));  // $toUserIds
        
        //$filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, array_intersect($peopleLikeIds, array_diff($peopleLikeIds, $mutualLikeIds)), $paginateCount, null);

        $filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, $totalIds, $paginateCount, [2,3] );

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                if( !$mutualLike ) {
                    $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                    $profilePictureUrl = noThumbImageURL();
                    // Check if user profile exists
                    if (!__isEmpty($filter)) {
                        if (!__isEmpty($filter->profile_picture)) {
                            $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                        }
                    }
                    $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                    $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                    //fetch like dislike data by to user id
                    $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                    
                    $userLikeData = [];
                    $userLikeDataValue = 0;
                    //check is not empty
                    if (!__isEmpty($likeDislikeData)) {
                        $userLikeData = [
                            '_id' => $likeDislikeData->_id,
                            'like' => $likeDislikeData->like,
                            'mutual' => $mutualLike,
                        ];
                        $userLikeDataValue = $likeDislikeData->like;
                    }
                    $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                    $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                    
                    // Gym setting data
                    $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                    $userGymsData = [];
                    //check if not empty
                    if (!__isEmpty($userGymsCollection)) {
                        foreach ($userGymsCollection as $key => $userGym) {
                            $userGymLogoUrl = '';
                            $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                            $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                            $userGymsData[] = [
                                'userGymLogoUrl' => $userGymLogoUrl,
                                'gymName'           => $userGym->gymName,
                                'gymId'          => $userGym->gymId  
                            ];
                        }
                    }

                    // Prepare data for filter
                    $filterData[] = [
                        'id'            => $filter->user_id,
                        'username'      => $filter->username,
                        'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                        'kanji_name'    => $filter->kanji_name,
                        'about_me'      => $filter->about_me,
                        'profileImage'  => $profilePictureUrl,
                        'gender'         => $gender,
                        'dob'             => $filter->dob,
                        'userAge'        => $userAge,
                        'countryName'     => $filter->countryName,
                        'city'            => $filter->city,  
                        'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                        'isPremiumUser'        => isPremiumUser($filter->user_id),
                        'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                        'likeData'    => $userLikeDataValue,
                        'userAvailability' => $usertime,
                        'totalReviewRate'    => $totalReviewRate,
                        'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                        'userGymsData'   => $userGymsData
                    ];
                }
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.pending_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    public function processFilterVisitorData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray(); 
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds)));  // $toUserIds
        
        $profileVisitorCollection = $this->userRepository->fetchProfileVisitor(getUserID());
        $visitorMeUserIds = $profileVisitorCollection->pluck('by_users__id')->toArray();

        $filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, $visitorMeUserIds, $paginateCount, [2,3]);

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }
                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                
                // Gym setting data
                $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                $userGymsData = [];
                //check if not empty
                if (!__isEmpty($userGymsCollection)) {
                    foreach ($userGymsCollection as $key => $userGym) {
                        $userGymLogoUrl = '';
                        $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                        $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                        $userGymsData[] = [
                            'userGymLogoUrl' => $userGymLogoUrl,
                            'gymName'           => $userGym->gymName,
                            'gymId'          => $userGym->gymId  
                        ];
                    }
                }

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'    => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'            => $filter->city,  
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userAvailability' => $usertime,
                    'totalReviewRate'    => $totalReviewRate,
                    'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                    'userGymsData'   => $userGymsData
                ];
                
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.visitor_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    public function processFilterBlockData($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds)));  // $toUserIds

        // Get filter collection data  --- PT user role -> 3
        $filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, $blockUserIds, $paginateCount, [2,3] );

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );

                // Gym setting data
                $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                $userGymsData = [];
                //check if not empty
                if (!__isEmpty($userGymsCollection)) {
                    foreach ($userGymsCollection as $key => $userGym) {
                        $userGymLogoUrl = '';
                        $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                        $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                        $userGymsData[] = [
                            'userGymLogoUrl' => $userGymLogoUrl,
                            'gymName'           => $userGym->gymName,
                            'gymId'          => $userGym->gymId  
                        ];
                    }
                }
            
                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'    => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'            => $filter->city,  
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userAvailability' => $usertime,
                    'totalReviewRate'    => $totalReviewRate,
                    'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                    'userGymsData'   => $userGymsData
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.blocked_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

        /**
     * Process Filter User Data.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processFilterDataPT($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds,  [getUserID()], $adminIds)));  // $mutualLikeIds,$toUserIds

        // Get filter collection data  --- PT user role -> 3
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount, 3);

        $filterData = $featuredFilterData = [];

        // Checking premium feature as distance within 10 km
        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);
        $userInfo = getUserAuthInfo();
        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro = $user_role != 'admin' && ( $featurePlanCollection[$user_role]['featured_profile_in_discovery']['select_user'] == 2);
        $hasFeature = ( $isAllowOnlyPro && ($userMembership == "pro" || $userMembership == "premium"));
        
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                // Gym setting data
                $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                $userGymsData = [];
                //check if not empty
                if (!__isEmpty($userGymsCollection)) {
                    foreach ($userGymsCollection as $key => $userGym) {
                        $userGymLogoUrl = '';
                        $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                        $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                        $userGymsData[] = [
                            'userGymLogoUrl' => $userGymLogoUrl,
                            'gymName'           => $userGym->gymName,
                            'gymId'          => $userGym->gymId  
                        ];
                    }
                }

                
                // Expertise setting data
                $userExpertiseCollection = $this->userRepository->fetchUserExpertiseData($filter->user_id);
                // Pt user pricing items
                $userPricingCollection = $this->userRepository->fetchUserSessionData($filter->user_id);
                
                $isFeaturedBadge = false;
                 if($hasFeature){
                    if( calculateDistance($userInfo['profile']['location_latitude'],$userInfo['profile']['location_longitude'],$filter->location_latitude,$filter->location_longitude ,"K") < 10 ) 
                    {
                        $isFeaturedBadge = true;
                    }
                 }

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'      => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'             => $filter->city,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userAvailability' => $usertime,
                    'totalReviewRate'    => $totalReviewRate,
                    'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                    'userGymsData'  => $userGymsData,
                    'userExpertiseData' => $userExpertiseCollection->toArray(),
                    'userPricingData'    => $userPricingCollection->toArray(),
                    'isFeaturedBadge' => $isFeaturedBadge,
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.pt_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }


    public function processFilterDataPTFollow($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();

        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds,  [getUserID()], $adminIds)));  // $mutualLikeIds,$toUserIds

        // Get filter collection data  --- PT user role -> 3
        $filterDataCollection = $this->userSettingRepository->fetchFilterDataWithIds($inputData, $toUserIds, $paginateCount, [3]);

        $filterData = $featuredFilterData = [];

        // Checking premium feature as distance within 10 km
        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);
        $userInfo = getUserAuthInfo();
        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro = $user_role != 'admin' && ( $featurePlanCollection[$user_role]['featured_profile_in_discovery']['select_user'] == 2);
        $hasFeature = ( $isAllowOnlyPro && ($userMembership == "pro" || $userMembership == "premium"));
        
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                // Gym setting data
                $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                $userGymsData = [];
                //check if not empty
                if (!__isEmpty($userGymsCollection)) {
                    foreach ($userGymsCollection as $key => $userGym) {
                        $userGymLogoUrl = '';
                        $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                        $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                        $userGymsData[] = [
                            'userGymLogoUrl' => $userGymLogoUrl,
                            'gymName'           => $userGym->gymName,
                            'gymId'          => $userGym->gymId  
                        ];
                    }
                }

                
                // Expertise setting data
                $userExpertiseCollection = $this->userRepository->fetchUserExpertiseData($filter->user_id);
                // Pt user pricing items
                $userPricingCollection = $this->userRepository->fetchUserSessionData($filter->user_id);
                
                $isFeaturedBadge = false;
                 if($hasFeature){
                    if( calculateDistance($userInfo['profile']['location_latitude'],$userInfo['profile']['location_longitude'],$filter->location_latitude,$filter->location_longitude ,"K") < 10 ) 
                    {
                        $isFeaturedBadge = true;
                    }
                 }

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'      => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'             => $filter->city,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userAvailability' => $usertime,
                    'totalReviewRate'    => $totalReviewRate,
                    'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                    'userGymsData'  => $userGymsData,
                    'userExpertiseData' => $userExpertiseCollection->toArray(),
                    'userPricingData'    => $userPricingCollection->toArray(),
                    'isFeaturedBadge' => $isFeaturedBadge,
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.pt_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    public function processFilterDataPTDistance($inputData, $paginateCount = false)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);
        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['distance'] = 15;
        $inputData['country'] = $userProfile->countries__id;
        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge( $blockUserIds, $blockMeUserIds,  [getUserID()], $adminIds)));  // $mutualLikeIds,$toUserIds

        // Get filter collection data  --- PT user role -> 3
        $filterDataCollection = $this->userSettingRepository->fetchFilterData($inputData, $ignoreUserIds, $paginateCount, 3);

        $filterData = $featuredFilterData = [];

        // Checking premium feature as distance within 10 km
        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);
        $userInfo = getUserAuthInfo();
        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro = $user_role != 'admin' && ( $featurePlanCollection[$user_role]['featured_profile_in_discovery']['select_user'] == 2);
        $hasFeature = ( $isAllowOnlyPro && ($userMembership == "pro" || $userMembership == "premium"));
        //print_r($filterDataCollection); exit;         
       
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter->user_uid]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter->profile_picture)) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter->profile_picture);
                    }
                }

                $userAge = isset($filter->dob) ? Carbon::parse($filter->dob)->age : null;
                $gender = isset($filter->gender) ? configItem('user_settings.gender', $filter->gender) : null;
                //fetch like dislike data by to user id
                $likeDislikeData = $this->userRepository->fetchLikeDislike($filter->user_id);
                $mutualLike = $this->userRepository->checkMutualFollow($filter->user_id);
                $userLikeData = [];
                $userLikeDataValue = 0;
                //check is not empty
                if (!__isEmpty($likeDislikeData)) {
                    $userLikeData = [
                        '_id' => $likeDislikeData->_id,
                        'like' => $likeDislikeData->like,
                        'mutual' => $mutualLike,
                    ];
                    $userLikeDataValue = $likeDislikeData->like;
                }
                $usertime = $this->userRepository->getUserAvailability($filter->user_id);
                $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $filter->user_id );
                // Gym setting data
                $userGymsCollection = $this->userRepository->fetchUserGymData($filter->user_id);
                $userGymsData = [];
                //check if not empty
                if (!__isEmpty($userGymsCollection)) {
                    foreach ($userGymsCollection as $key => $userGym) {
                        $userGymLogoUrl = '';
                        $userGymFolderPath = getPathByKey('gym_image', ['{_uid}' => $userGym->gymUId]);
                        $userGymLogoUrl = getMediaUrl($userGymFolderPath, $userGym->gymLogo);
                        $userGymsData[] = [
                            'userGymLogoUrl' => $userGymLogoUrl,
                            'gymName'           => $userGym->gymName,
                            'gymId'          => $userGym->gymId  
                        ];
                    }
                }

                
                // Expertise setting data
                $userExpertiseCollection = $this->userRepository->fetchUserExpertiseData($filter->user_id);
                // Pt user pricing items
                $userPricingCollection = $this->userRepository->fetchUserSessionData($filter->user_id);
                
                // $isFeaturedBadge = false;
                //  if($hasFeature){
                //     if( calculateDistance($userInfo['profile']['location_latitude'],$userInfo['profile']['location_longitude'],$filter->location_latitude,$filter->location_longitude ,"K") < 10 ) 
                //     {
                //         $isFeaturedBadge = true;
                //     }
                //  }

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter->user_id,
                    'username'      => $filter->username,
                    'fullName'      => $filter->kanji_name . ' ' . $filter->kata_name,
                    'kanji_name'      => $filter->kanji_name,
                    'about_me'      => $filter->about_me,
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter->dob,
                    'userAge'        => $userAge,
                    'countryName'     => $filter->countryName,
                    'city'             => $filter->city,
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter->user_authority_updated_at),
                    //'isPremiumUser'        => isPremiumUser($filter->user_id),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender])),
                    'likeData'    => $userLikeDataValue,
                    'userAvailability' => $usertime,
                    'totalReviewRate'    => $totalReviewRate,
                    'totalUserLike' => fetchTotalUserLikedCount($filter->user_id),
                    'userGymsData'  => $userGymsData,
                    'userExpertiseData' => $userExpertiseCollection->toArray(),
                    'userPricingData'    => $userPricingCollection->toArray(),
                    'isFeaturedBadge' => ( $filter->membership == "pro" || $filter->membership == "premium" ),
                ];
            }
        }

        $currentPage = $filterDataCollection->currentPage() + 1;
        // $fullUrl = Request::fullUrl();
        $fullUrl = route('user.read.pt_list');
        // check if url contains looking for
        if (!str_contains($fullUrl, 'looking_for')) {
            $fullUrl .= '?looking_for=' . getUserSettings('looking_for');
        }
        if (!str_contains($fullUrl, 'min_age')) {
            $fullUrl .= '&min_age=' . getUserSettings('min_age');
        }
        if (!str_contains($fullUrl, 'max_age')) {
            $fullUrl .= '&max_age=' . getUserSettings('max_age');
        }
        if (!str_contains($fullUrl, 'distance')) {
            $fullUrl .= '&distance=' . getUserSettings('distance');
        }

        // Check if user search data exists
        if (session()->has('userSearchData')) {
            session()->forget('userSearchData');
        }

        return $this->engineReaction(1, [
            'filterData'            => $filterData,
            'filterCount'           => count($filterData),
            'userSettings'          => configItem('user_settings'),
            'userSpecifications'    => $this->getUserSpecificationConfig(),
            'nextPageUrl'           => $fullUrl . '&page=' . $currentPage,
            'hasMorePages'          => $filterDataCollection->hasMorePages(),
            'totalCount'            => $filterDataCollection->total()
        ]);
    }

    /**
     * Process Filter User Data.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareRandomUserData($inputData)
    {
        // fetch current user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        // Store basic filter data
        if (!$this->userSettingEngine->processUserSettingStore('basic_search', $inputData)) {
            return $this->engineReaction(2, null, __tr('Something went wrong on server, please try again later.'));
        }

        $inputData = array_merge([
            'looking_for' => getUserSettings('looking_for'),
            'min_age' => getUserSettings('min_age'),
            'max_age' => getUserSettings('max_age'),
            'distance' => getUserSettings('distance'),
        ], $inputData);

        // check if looking for is given in string
        if ((!\__isEmpty($inputData['looking_for']))) {
            if ((\is_string($inputData['looking_for']))
                and ($inputData['looking_for'] == 'all')
            ) {
                $inputData['looking_for'] = [1, 2, 3];
            } else {
                $inputData['looking_for'] = [$inputData['looking_for']];
            }
        } else {
            $inputData['looking_for'] = [];
        }
        $latitude =  '';
        $longitude = '';
        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $latitude = $userProfile->location_latitude;
            $longitude = $userProfile->location_longitude;
        }

        $inputData['latitude'] = $latitude;
        $inputData['longitude'] = $longitude;

        //fetch all user like dislike data
        $getLikeDislikeData = $this->userRepository->fetchAllUserLikeDislike();
        //pluck to_users_id in array
        $toUserIds = $getLikeDislikeData->pluck('to_users__id')->toArray();
        // //all blocked user list
        $blockUserCollection = $this->userRepository->fetchAllBlockUser();
        //blocked user ids
        $blockUserIds = $blockUserCollection->pluck('to_users__id')->toArray();
        //blocked me user list
        $allBlockMeUser = $this->userRepository->fetchAllBlockMeUser();
        //blocked me user ids
        $blockMeUserIds = $allBlockMeUser->pluck('by_users__id')->toArray();
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('userId')->toArray();
        //can admin show in featured user
        $adminIds = [];
        //check condition is false
        if (!getStoreSettings('include_exclude_admin')) {
            //array merge of unique users ids
            $adminIds = $this->userRepository->fetchAdminIds();
        }
        //array merge of unique users ids
        $ignoreUserIds = array_values(array_unique(array_merge($toUserIds, $blockUserIds, $blockMeUserIds, $mutualLikeIds, [getUserID()], $adminIds)));

        //fetch filter booster user data
        $boosterUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreUserIds, 'boosterUser');

        //pluck booster user ids
        $boosterUserIds = $boosterUser->pluck('user_id')->toArray();

        $totalRandomUser = getStoreSettings('booster_user_count') + getStoreSettings('premium_user_count') + getStoreSettings('normal_user_count');
        $randomBoosterUserCount = getStoreSettings('booster_user_count');

        //check is not empty and booster user length greater than or equal to 4
        //then fetch 4 booster random user
        if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() >= $randomBoosterUserCount) {
            $randomBoosterUser = $boosterUser->random($randomBoosterUserCount)->toArray();
            $totalRandomUser = $totalRandomUser - count($randomBoosterUser);

            //check is not empty and booster user length less than 4
            //then total booster length count record
        } else if (!__isEmpty($boosterUser) and $randomBoosterUserCount > 0 and $boosterUser->count() < $randomBoosterUserCount) {
            $randomBoosterUser = $boosterUser->random($boosterUser->count())->toArray();
            $totalRandomUser = $totalRandomUser - count($randomBoosterUser);

            //if it is empty booster user then pass on blank array or total fetch user count
        } else {
            $randomBoosterUser = [];
            $totalRandomUser = $totalRandomUser - 0;
        }

        //array merge of unique users ids / or ignore booster filter user ids
        $ignoreBoosterUserIds = array_values(array_unique(array_merge($ignoreUserIds, $boosterUserIds)));

        //fetch filter premium user data
        $premiumUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignoreBoosterUserIds, 'premiumUser');

        //pluck premium user ids
        $premiumUserIds = $premiumUser->pluck('user_id')->toArray();

        $randomPremiumUserCount = getStoreSettings('premium_user_count');
        //check is not empty and premium user length greater than or equal to 4
        //then fetch 4 premium random user
        if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() >= $randomPremiumUserCount) {
            $randomPremiumUser = $premiumUser->random($randomPremiumUserCount)->toArray();
            $totalRandomUser = $totalRandomUser - count($randomPremiumUser);

            //check is not empty and premium user length less than 4
            //then total premium length count record
        } else if (!__isEmpty($premiumUser) and $randomPremiumUserCount > 0 and $premiumUser->count() < $randomPremiumUserCount) {
            $randomPremiumUser = $premiumUser->random($premiumUser->count())->toArray();
            $totalRandomUser = $totalRandomUser - count($randomPremiumUser);

            //if it is empty booster user then pass on blank array or total fetch user count
        } else {
            $randomPremiumUser = [];
            $totalRandomUser = $totalRandomUser - 0;
        }

        //array merge of unique users ids / or ignore booster Premium filter user ids
        $ignorePremiumUserIds = array_values(array_unique(array_merge($ignoreUserIds, $ignoreBoosterUserIds, $premiumUserIds)));
        //fetch filter premium user data
        $normalUser = $this->userSettingRepository->fetchFilterRandomUser($inputData, $ignorePremiumUserIds, 'normalUser');

        //check is not empty then fetch total count random user
        if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() >= $totalRandomUser) {
            $randomNormalUser = $normalUser->random($totalRandomUser)->toArray();
            //check is not empty and normal user length less than 4
            //then total normal length count record
        } else if (!__isEmpty($normalUser) and $totalRandomUser > 0 and $normalUser->count() < $totalRandomUser) {
            $randomNormalUser = $normalUser->random($normalUser->count())->toArray();
            //else fetch blank array
        } else {
            $randomNormalUser = [];
        }

        //get merge of fetch booster, premium and standard user data
        $filterDataCollection = array_merge($randomBoosterUser, $randomPremiumUser, $randomNormalUser);

        $filterData = [];
        // check if filter data exists
        if (!\__isEmpty($filterDataCollection)) {
            foreach ($filterDataCollection as $filter) {

                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $filter['user_uid']]);
                $profilePictureUrl = noThumbImageURL();
                // Check if user profile exists
                if (!__isEmpty($filter)) {
                    if (!__isEmpty($filter['profile_picture'])) {
                        $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $filter['profile_picture']);
                    }
                }

                $userAge = isset($filter['dob']) ? Carbon::parse($filter['dob'])->age : null;
                $gender = isset($filter['gender']) ? configItem('user_settings.gender', $filter['gender']) : null;

                // Prepare data for filter
                $filterData[] = [
                    'id'            => $filter['user_id'],
                    'username'      => $filter['username'],
                    'fullName'      => $filter['first_name'] . ' ' . $filter['last_name'],
                    'profileImage'  => $profilePictureUrl,
                    'gender'         => $gender,
                    'dob'             => $filter['dob'],
                    'userAge'        => $userAge,
                    'countryName'     => $filter['countryName'],
                    'userOnlineStatus' => $this->getUserOnlineStatus($filter['user_authority_updated_at']),
                    'isPremiumUser'        => isPremiumUser($filter['user_id']),
                    'detailString'    => implode(", ", array_filter([$userAge, $gender]))
                ];
            }
        }

        return $this->engineReaction(1, [
            'filterData' => $filterData
        ]);
    }

    public function fetchProfileVisitorCount(){
        $profileVisitorCollection = $this->userRepository->fetchProfileVisitor(getUserID());
        $visitorMeUserIds = $profileVisitorCollection->pluck('by_users__id')->toArray();
        return count($visitorMeUserIds);
    }
}
