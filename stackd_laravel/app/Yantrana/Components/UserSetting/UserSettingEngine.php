<?php
/**
* UserSettingEngine.php - Main component file.
*
* This file is part of the UserSetting component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\UserSetting;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Media\MediaEngine;
use App\Yantrana\Components\User\Repositories\UserRepository;
use App\Yantrana\Components\UserSetting\Interfaces\UserSettingEngineInterface;
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Support\Country\Repositories\CountryRepository;
use Illuminate\Support\Str;
use PushBroadcast;
use Stripe\Stripe;
use Exception;
use Carbon\Carbon;

class UserSettingEngine extends BaseEngine implements UserSettingEngineInterface
{
    /*
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
     * @var UserSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

    /**
     * @var CountryRepository - Country Repository
     */
    protected $countryRepository;

    /**
     * @var MediaEngine - Media Engine
     */
    protected $mediaEngine;

    /**
     * @var
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param UserSettingRepository $userSettingRepository - UserSetting Repository
     * @param CountryRepository     $countryRepository     - Country Repository
     * @param MediaEngine           $mediaEngine           - Media Engine
     *
     * @return void
     *-----------------------------------------------------------------------*/
    public function __construct(
        UserSettingRepository $userSettingRepository,
        CountryRepository $countryRepository,
        MediaEngine $mediaEngine,
        UserRepository $userRepository
    ) {
        $this->userSettingRepository = $userSettingRepository;
        $this->countryRepository = $countryRepository;
        $this->mediaEngine = $mediaEngine;
        $this->userRepository = $userRepository;
    }

    /**
     * Prepare User Settings.
     *
     * @param string $pageType
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareUserSettings($pageType)
    {
        // Get settings from config
        $defaultSettings = $this->getDefaultSettings(array_get($this->getUserSettingConfig(), "items.$pageType"));
        // check if default settings exists
        if (__isEmpty($defaultSettings)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('Invalid page type.'));
        }

        $userSettings = $dbUserSettings = [];
        // Check if default settings exists
        if (!__isEmpty($defaultSettings)) {
            // Get selected default settings
            $userSettingCollection = $this->userSettingRepository->fetchUserSettingByName(array_keys($defaultSettings));

            // check if configuration collection exists
            if (!__isEmpty($userSettingCollection)) {
                foreach ($userSettingCollection as $configuration) {
                    $dbUserSettings[$configuration->key_name] = $this->castValue($configuration->data_type, $configuration->value);
                }
            }

            // Loop over the default settings
            foreach ($defaultSettings as $defaultSetting) {
                $userSettings[$defaultSetting['key']] = $this->prepareDataForConfiguration($dbUserSettings, $defaultSetting);
            }
        }

        if ($pageType == 'notification') {
            $userSettings['user_choice_display_mobile_number'] = configItem('user_choice_display_mobile_number');
        }

        return $this->engineReaction(1, [
            'userSettingData' => $userSettings,
        ]);
    }

    /**
     * Process User Setting Store.
     *
     * @param string $pageType
     * @param array  $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processUserSettingStore($pageType, $inputData)
    {
        $dataForStoreOrUpdate = $userSettingKeysForDelete = [];
        $isDataAddedOrUpdated = false;

        // Get settings from config
        $defaultSettings = $this->getDefaultSettings($this->getUserSettingConfig()['items'][$pageType]);

        // check if default settings exists
        if (__isEmpty($defaultSettings)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('Invalid page type.'));
        }

        //check page type is notifications
        if ($pageType == 'notification') {
            if (!__isEmpty($inputData)) {
                foreach ($inputData as $key => $value) {
                    if ($key != 'display_user_mobile_number') {
                        $inputData[$key] = (isset($value) and $value == 'true') ? true : false;
                    }
                }
            }
        }
        // Check if input data exists
        if (!__isEmpty($inputData)) {
            foreach ($inputData as $inputKey => $inputValue) {
                // Get selected default settings
                $userSettingCollection = $this->userSettingRepository->fetchUserSettingByName(array_keys($defaultSettings));
                //pluck user setting value and key name
                $userSettingKeyName = $userSettingCollection->pluck('value', 'key_name')->toArray();

                // Check if default text and form text not same
                if (array_key_exists($inputKey, $defaultSettings) and $inputValue != $defaultSettings[$inputKey]['default']) {
                    $castValues = $this->castValue(
                        ($defaultSettings[$inputKey]['data_type'] == 4)
                            ? 5 : $defaultSettings[$inputKey]['data_type'], // for Encode purpose only
                        $inputValue
                    );
                    //if data exists in configuration then use existing data
                    if (array_key_exists($inputKey, $userSettingKeyName)) {
                        foreach ($userSettingCollection as $key => $settings) {
                            if ($inputKey == $settings['key_name']) {
                                $dataForStoreOrUpdate[] = [
                                    '_id' => $settings['_id'],
                                    'key_name' => $inputKey,
                                    'value' => $castValues,
                                    'data_type' => $defaultSettings[$inputKey]['data_type'],
                                    'users__id' => getUserID(),
                                ];
                            }
                        }
                    } else {
                        $dataForStoreOrUpdate[] = [
                            'key_name' => $inputKey,
                            'value' => $castValues,
                            'data_type' => $defaultSettings[$inputKey]['data_type'],
                            'users__id' => getUserID(),
                        ];
                    }
                }

                // Check if default value and input value same and it is exists
                if ((array_key_exists($inputKey, $defaultSettings))
                    and ($inputValue == $defaultSettings[$inputKey]['default'])
                    and (!isset($defaultSettings[$inputKey]['hide_value']))
                ) {
                    if (array_key_exists($inputKey, $userSettingKeyName)) {
                        foreach ($userSettingCollection as $key => $settings) {
                            if ($inputKey == $settings['key_name']) {
                                $userSettingKeysForDelete[] = $settings['_id'];
                            }
                        }
                    }
                }
            }
            // Send data for store or update
            if (
                !__isEmpty($dataForStoreOrUpdate)
                and $this->userSettingRepository->storeOrUpdate($dataForStoreOrUpdate)
            ) {
                activityLog('User settings stored / updated.');
                $isDataAddedOrUpdated = true;
            }

            // Check if deleted keys deleted successfully
            if (
                !__isEmpty($userSettingKeysForDelete)
                and $this->userSettingRepository->deleteUserSetting($userSettingKeysForDelete)
            ) {
                $isDataAddedOrUpdated = true;
            }

            // Check if data added / updated or deleted
            if ($isDataAddedOrUpdated) {
                return $this->engineReaction(1, ['show_message' => true], __tr('User setting updated successfully.'));
            }

            return $this->engineReaction(14, ['show_message' => true], __tr('Nothing updated.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server.'));
    }

    /*
      * Process Store User General Settings
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processStoreUserBasicSettings($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;
            // Prepare User Details
            $userDetails = [
                // 'first_name' => $inputData['first_name'],
                'last_name' => $inputData['last_name'],
                'mobile_number' => $inputData['mobile_number'],
            ];

            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($userDetails)) {
                return $this->engineReaction(18, null, __tr('User does not exists.'));
            }
            // check if user details updated
            if ($this->userSettingRepository->updateUser($user, $userDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own user info.');
                $isBasicSettingsUpdated = true;
            }

            // Prepare User profile details
            $userProfileDetails = [
                'kanji_name' => array_get($inputData, 'kanji_name'),
                'gender' => array_get($inputData, 'gender'),
                'dob' => array_get($inputData, 'birthday'),
                'work_status' => array_get($inputData, 'work_status'),
                'education' => array_get($inputData, 'education'),
                'about_me' => array_get($inputData, 'about_me'),
                'preferred_language' => array_get($inputData, 'preferred_language'),
                'relationship_status' => array_get($inputData, 'relationship_status'),
            ];

            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
            if (\__isEmpty($userProfile)) {
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            } else {
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' update own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /*
      * Process Store User General Settings
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processStoreUserAvailability($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $user_time = [];
            $user_time['mon_s'] = isset($inputData['mon_start']) ? 1 : 0;
            $user_time['mon_e'] = isset($inputData['mon_end']) ? 1 : 0;
            $user_time['tue_s'] = isset($inputData['tue_start']) ? 1 : 0;
            $user_time['tue_e'] = isset($inputData['tue_end']) ? 1 : 0;
            $user_time['wed_s'] = isset($inputData['wed_start']) ? 1 : 0;
            $user_time['wed_e'] = isset($inputData['wed_end']) ? 1 : 0;
            $user_time['thu_s'] = isset($inputData['thu_start']) ? 1 : 0;
            $user_time['thu_e'] = isset($inputData['thu_end']) ? 1 : 0;
            $user_time['fri_s'] = isset($inputData['fri_start']) ? 1 : 0;
            $user_time['fri_e'] = isset($inputData['fri_end']) ? 1 : 0;
            $user_time['sat_s'] = isset($inputData['sat_start']) ? 1 : 0;
            $user_time['sat_e'] = isset($inputData['sat_end']) ? 1 : 0;
            $user_time['sun_s'] = isset($inputData['sun_start']) ? 1 : 0;
            $user_time['sun_e'] = isset($inputData['sun_end']) ? 1 : 0;
            $user_time['user_id'] = getUserID();
            $this->userRepository->updateUserTime($user_time);

            return $this->userSettingRepository->transactionResponse(1, [], __tr('Your Availability Time updated successfully.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /*
      * process Store Profile Wizard
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processStoreProfileWizard($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;

            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($user)) {
                return $this->engineReaction(18, null, __tr('User does not exists.'));
            }

            // Prepare User profile details
            $userProfileDetails = [
                'gender' => array_get($inputData, 'gender'),
                'dob' => array_get($inputData, 'birthday'),
            ];

            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
            if (\__isEmpty($userProfile)) {
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            } else {
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' update own user profile.');

                    $isBasicSettingsUpdated = true;
                }
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Nothing to update'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process Store Location Data.
     *
     * @param array $inputData
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreLocationData($inputData)
    {
        // Get country from input data
        $placeData = $inputData['placeData'];
        // check if place data exists
        if (__isEmpty($placeData)) {
            return $this->engineReaction(2, null, __tr('Invalid data proceed.'));
        }

        $countryCode = $cityName = $countryName = '';
        // Loop over the place data
        foreach ($placeData as $place) {
            if (in_array('country', $place['types']) or in_array('continent', $place['types'])) {
                $countryCode = $place['short_name'];
                $countryName = $place['long_name'];
            }
            if (in_array('locality', $place['types'])) {
                $cityName = $place['long_name'];
            }
        }
        // Fetch Country code
        $countryDetails = $this->countryRepository->fetchByCountryCode($countryCode);

        //check is empty then show error message
        if (__isEmpty($countryDetails)) {
            return $this->engineReaction(18, null, __tr('Select your country level precise location.'));
        }

        $countryId = $countryDetails->_id;
        $countryName = $countryDetails->name;
        $isUserLocationUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        $userProfileDetails = [
            'countries__id' => $countryId,
            'city' => $cityName,
            'location_latitude' => $inputData['latitude'],
            'location_longitude' => $inputData['longitude'],
            'formatted_address' => $inputData['formatted_address'],
        ];
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        // check if user profile exists
        if (\__isEmpty($userProfile)) {
            $userProfileDetails['user_id'] = $userId;
            if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' store own location.');
                $isUserLocationUpdated = true;
            }
        } else {
            if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own location.');
                $isUserLocationUpdated = true;
            }
        }

        // check if user profile stored or update
        if ($isUserLocationUpdated) {
            return $this->engineReaction(1, [
                'country_name' => $countryName,
                'city' => $cityName,
            ], __tr('Location stored successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
     * Process upload profile image.
     *
     * @param array  $inputData
     * @param string $requestType
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadProfileImage($inputData, $requestType)
    {
        $uploadedFile = $this->mediaEngine->processUploadProfile($inputData, $requestType);
        $isProfilePictureUpdated = false;
        // check if file uploaded successfully
        if ($uploadedFile['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFile['data'];
            $fileName = $uploadedFileData['fileName'];
            $userId = getUserID();
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            // get user profile data
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

            $userProfileData = [
                'profile_picture' => $fileName,
            ];

            // check if user profile exists
            if (__isEmpty($userProfile)) {
                $userProfileData['user_id'] = $userId;
                // Check if user profile stored
                if ($this->userSettingRepository->storeUserProfile($userProfileData)) {
                    activityLog($fullName.' store profile picture.');
                    $isProfilePictureUpdated = true;
                }
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->profile_picture)) {
                    $profileFolderPath = getPathByKey('profile_photo', ['{_uid}' => authUID()]);
                    $this->mediaEngine->delete($profileFolderPath, $userProfile->profile_picture);
                }
                // Check if user profile updated
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileData)) {
                    activityLog($fullName.' update profile picture.');
                    $isProfilePictureUpdated = true;
                }
            }
        }
        // check if profile picture updated successfully.
        if ($isProfilePictureUpdated) {
            return $this->engineReaction(1, [
                'image_url' => $uploadedFileData['path'],
            ], __tr('Profile picture updated successfully.'));
        }

        return $uploadedFile;
    }

    public function processUploadProfileImageBlob($inputData, $requestType)
    {
        $userId = getUserID();
        $userInfo = getUserAuthInfo();
        $fullName = array_get($userInfo, 'profile.full_name');
        // get user profile data
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
        
        // store profile image
        $fileName = '';
        $base64Image = $inputData['profile_image'];
        $uploadedFileOnLocalServer = $this->mediaEngine->processSaveBase64ImageToLocalServer($base64Image, $requestType, authUID(), $requestType);
        $isProfilePictureUpdated = false;

        if ($uploadedFileOnLocalServer['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFileOnLocalServer['data'];
            $fileName = $uploadedFileData['fileName'];
        
            $userProfileData = [
                'profile_picture' => $fileName,
            ];

            // check if user profile exists
            if (__isEmpty($userProfile)) {
                $userProfileData['user_id'] = $userId;
                // Check if user profile stored
                if ($this->userSettingRepository->storeUserProfile($userProfileData)) {
                    activityLog($fullName.' store profile picture.');
                    $isProfilePictureUpdated = true;
                }
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->profile_picture)) {
                    $profileFolderPath = getPathByKey('profile_photo', ['{_uid}' => authUID()]);
                    $this->mediaEngine->delete($profileFolderPath, $userProfile->profile_picture);
                }
                // Check if user profile updated
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileData)) {
                    activityLog($fullName.' update profile picture.');
                    $isProfilePictureUpdated = true;
                }
            }
        }
        // check if profile picture updated successfully.
        if ($isProfilePictureUpdated) {
            return $this->engineReaction(1, [
                'image_url' => $uploadedFileData['path'],
            ], __tr('Profile picture updated successfully.'));
        }

        return $uploadedFileOnLocalServer;
    }

    /**
     * Process upload cover image.
     *
     * @param array  $inputData
     * @param string $requestType
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadCoverImage($inputData, $requestType)
    {
        $uploadedFile = $this->mediaEngine->processUploadCoverPhoto($inputData, $requestType);
        $isCoverPictureUpdated = false;
        // check if file uploaded successfully
        if ($uploadedFile['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFile['data'];
            $fileName = $uploadedFileData['fileName'];
            $userId = getUserID();
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            // get user profile data
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            $userProfileData = [
                'cover_picture' => $fileName,
            ];

            // check if user profile exists
            if (__isEmpty($userProfile)) {
                $userProfileData['user_id'] = $userId;
                // Check if user profile stored
                if ($this->userSettingRepository->storeUserProfile($userProfileData)) {
                    activityLog($fullName.' store cover picture.');
                    $isCoverPictureUpdated = true;
                }
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->cover_picture)) {
                    $profileFolderPath = getPathByKey('cover_photo', ['{_uid}' => authUID()]);

                    $this->mediaEngine->delete($profileFolderPath, $userProfile->cover_picture);
                }
                // Check if user profile updated
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileData)) {
                    activityLog($fullName.' update cover picture.');
                    $isCoverPictureUpdated = true;
                }
            }
        }
        // check if cover picture updated successfully.
        if ($isCoverPictureUpdated) {
            return $this->engineReaction(1, [
                'image_url' => $uploadedFileData['path'],
            ], __tr('Profile cover picture updated successfully.'));
        }

        return $uploadedFile;
    }

    /*
      * Process Store User Profile Data
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processStoreUserProfileSetting($inputData)
    {
        $userId = getUserID();
        $userSpecifications = $storeOrUpdateData = [];
        // Get collection of user specifications
        $userSpecificationCollection = $this->userSettingRepository->fetchUserSpecificationById($userId);
        // check if user specification exists
        if (!__isEmpty($userSpecificationCollection)) {
            $userSpecifications = $userSpecificationCollection->pluck('_id', 'specification_key')->toArray();
        }
        $index = 0;
        foreach ($inputData as $inputKey => $inputValue) {
            if (!__isEmpty($inputValue)) {
                $storeOrUpdateData[$index] = [
                    'type' => 1,
                    'status' => 1,
                    'specification_key' => $inputKey,
                    'specification_value' => $inputValue,
                    'users__id' => $userId,
                ];
                if (array_key_exists($inputKey, $userSpecifications)) {
                    $storeOrUpdateData[$index]['_id'] = $userSpecifications[$inputKey];
                }
                ++$index;
            }
        }

        // Check if user profile updated or store
        if ($this->userSettingRepository->storeOrUpdateUserSpecification($storeOrUpdateData)) {
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            activityLog($fullName.' update own user settings.');

            return $this->engineReaction(1, null, __tr('Profile updated successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
     * Prepare user photo settings.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function prepareUserPhotosSettings()
    {
        $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos(getUserID());
        $userPhotos = [];
        $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => authUID()]);
        // check if user photos exists
        if (!__isEmpty($userPhotoCollection)) {
            foreach ($userPhotoCollection as $photo) {
                $removePhotoUrl = route('user.upload_photos.write.delete', ['photoUid' => $photo->_uid]);
                $likePhotoUrl = route('user.upload_photos.write.like', ['photoUid' => $photo->_uid]);
                $taggedPhotoUrl = route('user.upload_photos.write.tagged', ['photoUid' => $photo->_uid]);
                //if mobile request
                if (isMobileAppRequest()) {
                    $removePhotoUrl = route('api.user.upload_photos.write.delete', ['photoUid' => $photo->_uid]);
                }

                $userPhotos[] = [
                    '_id' => $photo->_id,
                    '_uid' => $photo->_uid,
                    'is_like' => $photo->is_like,
                    'is_tagged' => $photo->is_tagged,
                    'removePhotoUrl' => $removePhotoUrl,
                    'likePhotoUrl' => $likePhotoUrl,
                    'taggedPhotoUrl' => $taggedPhotoUrl,
                    'comment' => $photo->comment,
                    'image_url' => getMediaUrl($userPhotosFolderPath, $photo->file),
                ];
            }
        }

        return $this->engineReaction(1, [
            'userPhotos' => $userPhotos,
            'photosCount' => $userPhotoCollection->count(),
            'photosMediaRestriction' => getMediaRestriction('photos'),
        ]);
    }

    /**
     * Process Upload Multiple Photos.
     *
     * @param array $inputData
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUploadPhotos($inputData)
    {
        $userPhotoCollection = $this->userSettingRepository->fetchUserPhotos(getUserID());

        // Check if user photos count is greater than or equal to 10
        if ($userPhotoCollection->count() >= getStoreSettings('user_photo_restriction')) {
            return $this->engineReaction(2, null, __tr('You cannot upload more than __limit__ photos.', ['__limit__' => getStoreSettings('user_photo_restriction')]));
        }

        $uploadedFile = $this->mediaEngine->uploadUserPhotos($inputData, 'photos');

        // check if file uploaded successfully
        if ($uploadedFile['reaction_code'] == 1) {
            $userPhotoData = [
                'users__id' => getUserID(),
                'file' => $uploadedFile['data']['fileName'],
            ];

            if ($newUserPhoto = $this->userSettingRepository->storeUserPhoto($userPhotoData)) {
                $userInfo = getUserAuthInfo();
                $fullName = array_get($userInfo, 'profile.full_name');
                activityLog($fullName.' upload new photos.');
                $likePhotoUrl = route('user.upload_photos.write.like', ['photoUid' => $newUserPhoto->_uid]);
                $taggedPhotoUrl = route('user.upload_photos.write.tagged', ['photoUid' => $newUserPhoto->_uid]);
                return $this->engineReaction(1, [
                    'stored_photo' => [
                        '_id' => $newUserPhoto->_id,
                        '_uid' => $newUserPhoto->_uid,
                        'is_like' => $newUserPhoto->is_like,
                        'is_tagged' => $newUserPhoto->is_tagged,
                        'comment' => $newUserPhoto->comment,
                        'removePhotoUrl' => route('user.upload_photos.write.delete', ['photoUid' => $newUserPhoto->_uid]),
                        'likePhotoUrl' => $likePhotoUrl,
                        'taggedPhotoUrl' => $taggedPhotoUrl,
                        'image_url' => $uploadedFile['data']['path'],
                    ],
                ], __tr('Photos uploaded successfully.'));
            }
        }

        return $uploadedFile;
    }

    /**
     * Process delete user photos.
     *
     * @param array $photoUid
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processDeleteUserPhotos($photoUid)
    {
        $userPhotos = $this->userSettingRepository->fetchUserPhotosById($photoUid);

        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        //delete photo
        if ($photo = $this->userSettingRepository->deletePhoto($userPhotos)) {
            //delete photo from user photos in media storage
            $photoImageFolderPath = getPathByKey('user_photos', ['{_uid}' => authUID()]);

            //delete photo from media storage
            $this->mediaEngine->delete($photoImageFolderPath, $photo->file);

            $this->userSettingRepository->deletePhotoComment($userPhotos->_id);
            $this->userSettingRepository->deletePhotoFeed($userPhotos->_id);
            //success response
            return $this->engineReaction(1, [
                'show_message' => true,
                'photoUid' => $photo->_uid,
            ], __tr('Photo deleted successfully.'));
        }

        //error response
        return $this->engineReaction(18, null, __tr('Gift not deleted.'));
    }

    public function processLikeUserPhotos($photoUid)
    {
        $userPhotos = $this->userSettingRepository->fetchUserPhotosById($photoUid);

        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        $newValue = 1;
        if($userPhotos["is_like"] == 1)
        {
            $newValue = 0;
        }
        //delete photo
        if ($this->userSettingRepository->updateUserPhoto($userPhotos, ['is_like' => $newValue])) {
            
            //success response
            return $this->engineReaction(1, [
                'show_message' => true,
                'photoUid' => $photoUid,
                'is_like' => $newValue
            ], __tr('Photo updated successfully.'));
        }

        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }
    public function processTaggedUserPhotos($photoUid)
    {
        $userPhotos = $this->userSettingRepository->fetchUserPhotosById($photoUid);
        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        $newValue = 1;
        if($userPhotos["is_tagged"] == 1)
        {
            $newValue = 0;
        }

        //delete photo
        if ($this->userSettingRepository->updateUserPhoto($userPhotos, ['is_tagged' => $newValue])) {
            
            //success response
            return $this->engineReaction(1, [
                'show_message' => true,
                'photoUid' => $photoUid,
                'is_tagged' => $newValue
            ], __tr('Photo updated successfully.'));
        }

        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }

    public function processEditUserPhotos($inputData){
        $photoUid = $inputData["post_photo_uid"];
        $userPhotos = $this->userSettingRepository->fetchUserPhotosById($photoUid);
        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        if ($this->userSettingRepository->updateUserPhoto($userPhotos, ['comment' => $inputData["comment"]])) {
            //success response
            return $this->engineReaction(1, [
                'show_message' => true,
                'photoUid' => $photoUid,
                'comment' => $inputData["comment"]
            ], __tr('Photo updated successfully.'));
        }

        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }


    public function processLikeUserFeed($photoUid)
    {
        $userPhotos = $this->userSettingRepository->fetchPhotosByUId($photoUid);

        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        $photoOwnUser = $this->userSettingRepository->fetchUserDetails($userPhotos->users__id);

        $userFeed = $this->userSettingRepository->fetchUserFeedByPhotoUId($userPhotos->_id);

        //check is not empty
        if (__isEmpty($userFeed)) {
            if ($this->userSettingRepository->insertUserFeed( [['_id'=>0,'is_like' => 1, 'photo__id'=> $userPhotos->_id, 'users__id'=>getUserId(),'status'=>1]] )) {
                
                $userInfo = getUserAuthInfo();
                $loggedInUserName = array_get($userInfo, 'profile.full_name');
                notificationLog($loggedInUserName.' liked your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-like-photo");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'user-like-photo',
                    'userUid' => $photoOwnUser->_id,
                    'subject' => __tr('Like a photo'),
                    'message' => $loggedInUserName.__tr(' liked your photo. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                    'getNotificationList' => getNotificationList($photoOwnUser->_id),
                ]);
                
                //success response
                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'is_like' => 1
                ], __tr('Feed updated successfully.'));
            }
        } else {
            $newValue = 1;
            if($userFeed->is_like == 1)
            {
                $newValue = 0;
            }
            if ($this->userSettingRepository->updateUserFeed($userFeed, ['is_like' => $newValue])) {

                if($newValue)
                {

                    $userInfo = getUserAuthInfo();
                    $loggedInUserName = array_get($userInfo, 'profile.full_name');
                    
                    notificationLog($loggedInUserName.' liked your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-like-photo");

                    //push data to pusher
                    PushBroadcast::notifyViaPusher('event.user.notification', [
                        'type' => 'user-like-photo',
                        'userUid' => $photoOwnUser->_id,
                        'subject' => __tr('Like a photo'),
                        'message' => $loggedInUserName.__tr(' liked your photo. '),
                        'messageType' => __tr('success'),
                        'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                        'getNotificationList' => getNotificationList($photoOwnUser->_id),
                    ]);
                }
                //success response
                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'is_like' => $newValue
                ], __tr('Feed updated successfully.'));
            }
        }
        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }

    public function processTaggedUserFeed($photoUid)
    {
        $userPhotos = $this->userSettingRepository->fetchPhotosByUId($photoUid);
        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        $userFeed = $this->userSettingRepository->fetchUserFeedByPhotoUId($userPhotos->_id);
        $photoOwnUser = $this->userSettingRepository->fetchUserDetails($userPhotos->users__id);
        //check is not empty
        if (__isEmpty($userFeed)) {
            if ($this->userSettingRepository->insertUserFeed( [['_id'=>0,'is_tagged' => 1, 'photo__id'=> $userPhotos->_id, 'users__id'=>getUserId(),'status'=>1]] )) {
                //success response

                $userInfo = getUserAuthInfo();
                $loggedInUserName = array_get($userInfo, 'profile.full_name');

                notificationLog($loggedInUserName.' tagged your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-tag-photo");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'user-tag-photo',
                    'userUid' => $photoOwnUser->_id,
                    'subject' => __tr('Tag a photo'),
                    'message' => $loggedInUserName.__tr(' tagged your photo. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                    'getNotificationList' => getNotificationList($photoOwnUser->_id),
                ]);
                
                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'is_tagged' => 1
                ], __tr('Feed updated successfully.'));
            }
        } else {
            $newValue = 1;
            if($userFeed->is_tagged == 1)
            {
                $newValue = 0;
            }
            if ($this->userSettingRepository->updateUserFeed($userFeed, ['is_tagged' => $newValue])) {
                //success response

                if($newValue)
                {

                    $userInfo = getUserAuthInfo();
                    $loggedInUserName = array_get($userInfo, 'profile.full_name');
                    
                    notificationLog($loggedInUserName.' tagged your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-tag-photo");

                    //push data to pusher
                    PushBroadcast::notifyViaPusher('event.user.notification', [
                        'type' => 'user-tag-photo',
                        'userUid' => $photoOwnUser->_id,
                        'subject' => __tr('Tag a photo'),
                        'message' => $loggedInUserName.__tr(' tagged your photo. '),
                        'messageType' => __tr('success'),
                        'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                        'getNotificationList' => getNotificationList($photoOwnUser->_id),
                    ]);
                }

                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'is_tagged' => $newValue
                ], __tr('Feed updated successfully.'));
            }
        }
        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }

    public function processEditUserFeed($inputData){
        $photoUid = $inputData["post_photo_uid"];
        $userPhotos = $this->userSettingRepository->fetchPhotosByUId($photoUid);
        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        $userFeed = $this->userSettingRepository->fetchUserFeedByPhotoUId($userPhotos->_id);

        //check is not empty
        if (__isEmpty($userFeed)) {
            if ($this->userSettingRepository->insertUserFeed( [['_id'=>0,'comment' => $inputData['comment'], 'photo__id'=> $userPhotos->_id, 'users__id'=>getUserId(),'status'=>1]] )) {
                //success response

                $userInfo = getUserAuthInfo();
                $loggedInUserName = array_get($userInfo, 'profile.full_name');
                
                notificationLog($loggedInUserName.' had commented your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-comment-photo");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'user-comment-photo',
                    'userUid' => $photoOwnUser->_id,
                    'subject' => __tr('Comment a photo'),
                    'message' => $loggedInUserName.__tr(' had commented your photo. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                    'getNotificationList' => getNotificationList($photoOwnUser->_id),
                ]);
                
                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'comment' => $inputData['comment']
                ], __tr('Feed updated successfully.'));
            }
        } else {
            
            if ($this->userSettingRepository->updateUserFeed($userFeed, ['comment' => $inputData['comment']])) {
                //success response

                $userInfo = getUserAuthInfo();
                $loggedInUserName = array_get($userInfo, 'profile.full_name');
                
                notificationLog($loggedInUserName.' had commented your photo. ', route('user.profile_view', ['username' => $photoOwnUser->username]), null, $photoOwnUser->_id, getUserID(), "user-comment-photo");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'user-comment-photo',
                    'userUid' => $photoOwnUser->_id,
                    'subject' => __tr('Comment a photo'),
                    'message' => $loggedInUserName.__tr(' had commented your photo. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $photoOwnUser->_id),
                    'getNotificationList' => getNotificationList($photoOwnUser->_id),
                ]);
                

                return $this->engineReaction(1, [
                    'show_message' => true,
                    'photoUid' => $photoUid,
                    'photo_id' => $userPhotos->_id,
                    'comment' => $inputData['comment']
                ], __tr('Feed updated successfully.'));
            }
        }

        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }

    public function processCommentUserFeed($inputData){
        $photoUid = $inputData["post_photo_uid"];
        $userPhotos = $this->userSettingRepository->fetchPhotosByUId($photoUid);
        //check is not empty
        if (__isEmpty($userPhotos)) {
            return $this->engineReaction(2, null, __tr('User photo not found.'));
        }

        if ($this->userSettingRepository->insertUserPhotoComment( [['_id'=>0,'comment' => $inputData['comment'], 'photo__id'=> $userPhotos->_id, 'users__id'=>getUserId(),'status'=>1]] )) {
            //success response

            $userId = getUserID();
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            // get user profile data
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            $profilePictureUrl = "";
            // check if user profile exists
            if (__isEmpty($userProfile)) {
                
            } else {
                // check if existing profile picture exists
                if (!__isEmpty($userProfile->profile_picture)) {
                    $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => authUID()]);
                    $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userProfile->profile_picture);
                }
            } 
            
            $photo_owner_id = $userPhotos->users__id;
            $photo_owner = $this->userSettingRepository->fetchUserDetails($photo_owner_id);

            //notification log message
            notificationLog($fullName.' has commented on your photo. ', route('user.profile_view', ['username' => $photo_owner->username]), null, $photo_owner_id, $userId, 'user-comment-photo');

            //push data to pusher
            PushBroadcast::notifyViaPusher('event.user.notification', [
                'type' => 'user-comment-photo',
                'userUid' => $photo_owner->userUId,
                'subject' => __tr('User has commented on your photo successfully'),
                'message' => $fullName.__tr(' has commented on your photo. '),
                'messageType' => __tr('success'),
                'showNotification' => getUserSettings('show_user_login_notification', $photo_owner_id),
                'getNotificationList' => getNotificationList($photo_owner_id),
            ]);
        
            return $this->engineReaction(1, [
                'show_message' => true,
                'photoUid' => $photoUid,
                'photo_id' => $userPhotos->_id,
                'comment' => $inputData['comment'],
                'profilePictureUrl' => $profilePictureUrl,
                'create_at'  => date("Y-m-d H:i:s")
            ], __tr('Feed updated successfully.'));
        }
        
        //error response
        return $this->engineReaction(18, null, __tr('Not Done.'));
    }
    
    /**
     * Process delete user photos.
     *
     * @param array $searchQuery
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function searchStaticCities($searchQuery)
    {
        if (!$searchQuery or !is_string($searchQuery)) {
            return $this->engineReaction(2, null, __tr('Search query should be valid string'));
        }

        if (Str::length($searchQuery) < 2) {
            return $this->engineReaction(2, null, __tr('At least 2 characters are required'));
        }

        $searchQueryResult = $this->userSettingRepository->searchStaticCities($searchQuery);
        // dd( $searchQueryResult);
        return $this->engineReaction(1, [
            'show_message' => false,
            'search_result' => $searchQueryResult,
        ], __tr('Search result'));
    }

    /**
     * Process search gym.
     *
     * @param array $searchQuery
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function searchStaticGym($searchQuery)
    {
        if (!$searchQuery or !is_string($searchQuery)) {
            return $this->engineReaction(2, null, __tr('Search query should be valid string'));
        }

        if (Str::length($searchQuery) < 2) {
            return $this->engineReaction(2, null, __tr('At least 2 characters are required'));
        }

        $searchQueryResult = $this->userSettingRepository->searchStaticGym($searchQuery);
        // dd( $searchQueryResult);
        return $this->engineReaction(1, [
            'show_message' => false,
            'search_result' => $searchQueryResult,
        ], __tr('Search result'));
    }

    public function searchStaticExpertise($searchQuery)
    {
        if (!$searchQuery or !is_string($searchQuery)) {
            return $this->engineReaction(2, null, __tr('Search query should be valid string'));
        }

        if (Str::length($searchQuery) < 2) {
            return $this->engineReaction(2, null, __tr('At least 2 characters are required'));
        }

        $searchQueryResult = $this->userSettingRepository->searchStaticExpertise($searchQuery);
        // dd( $searchQueryResult);
        return $this->engineReaction(1, [
            'show_message' => false,
            'search_result' => $searchQueryResult,
        ], __tr('Search result'));
    }

    /**
     * Process Store Location City.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreCity($cityId)
    {
        $cityData = $this->userSettingRepository->fetchCity($cityId);

        //check is empty then show error message
        if (__isEmpty($cityData)) {
            return $this->engineReaction(18, null, __tr('Selected city not found'));
        }

        $cityName = $cityData->name;
        // Fetch Country code
        $countryDetails = $this->countryRepository->fetchByCountryCode($cityData->country_code);

        //check is empty then show error message
        if (__isEmpty($countryDetails)) {
            return $this->engineReaction(18, null, __tr('Country not found'));
        }

        $countryId = $countryDetails->_id;
        $countryName = $countryDetails->name;
        $isUserLocationUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        $userProfileDetails = [
            'countries__id' => $countryId,
            'city' => $cityName,
            'location_latitude' => $cityData->latitude,
            'location_longitude' => $cityData->longitude,
        ];
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        // check if user profile exists
        if (\__isEmpty($userProfile)) {
            $userProfileDetails['user_id'] = $userId;
            if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' store own location.');
                $isUserLocationUpdated = true;
            }
        } else {
            if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own location.');
                $isUserLocationUpdated = true;
            }
        }

        // check if user profile stored or update
        if ($isUserLocationUpdated) {
            return $this->engineReaction(1, [
                'country_name' => $countryName,
                'city' => $cityName,
            ], __tr('Location stored successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /*
      * Process Settings Account
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    // Original function ...
    public function processSettingAccount_Original($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;
            // Prepare User Details
            $userDetails = [
                  // 'first_name' => $inputData['first_name'],
                  'last_name' => $inputData['last_name'],
                  'mobile_number' => $inputData['mobile_number'],
              ];

            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($userDetails)) {
                return $this->engineReaction(18, null, __tr('User does not exists.'));
            }
            // check if user details updated
            if ($this->userSettingRepository->updateUser($user, $userDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own user info.');
                $isBasicSettingsUpdated = true;
            }

            // Prepare User profile details
            $userProfileDetails = [
                  'kanji_name' => array_get($inputData, 'kanji_name'),
                  'gender' => array_get($inputData, 'gender'),
                  'dob' => array_get($inputData, 'birthday'),
                  'work_status' => array_get($inputData, 'work_status'),
                  'education' => array_get($inputData, 'education'),
                  'about_me' => array_get($inputData, 'about_me'),
                  'preferred_language' => array_get($inputData, 'preferred_language'),
                  'relationship_status' => array_get($inputData, 'relationship_status'),
              ];

            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
            if (\__isEmpty($userProfile)) {
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            } else {
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' update own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /*
      * Process Settings Account
      *
      * @param array $inputData
      *
      * @return boolean.
      *-------------------------------------------------------- */
    public function processUserSettingAccount($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;
            // Prepare User Details
            $userDetails = [
                    'username' => $inputData['username'],
                ];
            
            $userId = getUserID();             
            $user = $this->userSettingRepository->fetchUserDetails($userId);             
            
            // Check if user details exists
            if (\__isEmpty($user)) {
                return $this->engineReaction(18, null, __tr('User does not exists.'));
            } 
            
            $userFromUsername = $this->userSettingRepository->fetchUserWithUsername($userId, $inputData['username']);
            // Check if user details exists
            if (!\__isEmpty($userFromUsername)) {
                return $this->userSettingRepository->transactionResponse(18, ['userData'=>$user], __tr('This username is already in use.'));
            }
            
            // check if user details updated
            if ($this->userSettingRepository->updateUser($user, $userDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own user info.'.json_encode($userDetails));
                $isBasicSettingsUpdated = true;
            }
            // Prepare User profile details
            $userProfileDetails = [
                    'kanji_name' => array_get($inputData, 'kanji_name'),
               //     'gender' => array_get($inputData, 'gender'),
               //     'dob' => array_get($inputData, 'birthday'),
               //     'work_status' => array_get($inputData, 'work_status'),
               //     'education' => array_get($inputData, 'education'),
                    'about_me' => array_get($inputData, 'about_me'),
               //      'preferred_language' => array_get($inputData, 'preferred_language'),
               //      'relationship_status' => array_get($inputData, 'relationship_status'),
                    'do_qualify' => array_get($inputData, 'do_qualify'),
                    'website' => array_get($inputData, 'website'),
                ];

            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);  

            // check if user profile exists
            if (\__isEmpty($userProfile)) { 
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {

                    activityLog($user->first_name.' '.$user->last_name.' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
                if ( $inputData["gym_selected_list"] != ""){
                    $this->userRepository->deleteUserGymData($userId);
                    $gymList = explode(",", $inputData["gym_selected_list"]);
                    // Loop over the gym id list data
                    foreach ($gymList as $gym_id) {
                        $this->userRepository->storeUserGymData($gym_id, $userId);
                    }
                }
                $isBasicSettingsUpdated = true;
            } else {             
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    
                    activityLog($user->first_name.' '.$user->last_name.' update own user profile.'.json_encode($userProfileDetails));
                    $isBasicSettingsUpdated = true;
                }
                if ( $inputData["gym_selected_list"] != ""){
                    $this->userRepository->deleteUserGymData($userId);
                    $gymList = explode(",", $inputData["gym_selected_list"]);
                    // Loop over the gym id list data
                    foreach ($gymList as $gym_id) {
                        $this->userRepository->storeUserGymData($gym_id, $userId);
                    }
                }
                $isBasicSettingsUpdated = true;
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, ['userData'=>$user], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function processStoreExpertiseData($inputData)
    {

        $expertiseIds = explode(',',$inputData["expertise_selected_list"]);
        //check is empty then show error message
        if (__isEmpty($expertiseIds)) {
            return $this->engineReaction(18, null, __tr('No expertise requested'));
        }

        $isUserExpertiseUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $this->userRepository->deleteUserExpertiseData($userId);
            // Loop over the id list data
            foreach ($expertiseIds as $expertise_id) {
                $this->userRepository->storeUserExpertiseData($expertise_id, $userId);
            }

            $isUserExpertiseUpdated = true;
        }
        // check if user profile stored or update
        if ($isUserExpertiseUpdated) {

            $newUserExpertiseData = $this->userRepository->fetchUserExpertiseData($userId)->toArray();

            return $this->engineReaction(1, [
                'stored_expertise_list' => $newUserExpertiseData,
            ], __tr('Expertise stored successfully.'));
        }
        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    public function processStoreSessionData($inputData)
    {

        $isUserSessionUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $this->userRepository->storeOrUpdateUserSessionData($inputData, $userId);
            $isUserSessionUpdated = true;
        }
        // check if user profile stored or update
        if ($isUserSessionUpdated) {

            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            //get people likes me data
            $userLikedMeData = $this->userRepository->fetchUserLikeMeData();
            //check user like data exists
            if (!__isEmpty($userLikedMeData)) {
                foreach ($userLikedMeData as $userLike) {
                    //notification log message
                    notificationLog($fullName.' that you follow has updated their price. ', route('user.profile_view', ['username' => $userLike->username]), null, $userLike->userId, $userId, 'update-price');

                    //push data to pusher
                    PushBroadcast::notifyViaPusher('event.user.notification', [
                        'type' => 'update-price',
                        'userUid' => $userLike->userUId,
                        'subject' => __tr('User that you follow has updated their price'),
                        'message' => $fullName.__tr(' that you follow has updated their price. '),
                        'messageType' => __tr('success'),
                        'showNotification' => getUserSettings('show_user_login_notification', $userLike->userId),
                        'getNotificationList' => getNotificationList($userLike->userId),
                    ]);
                }
            }
            

            $newUserSessionData = $this->userRepository->fetchUserSessionData($userId)->toArray();

            return $this->engineReaction(1, [
                'stored_session_list' => $newUserSessionData,
            ], __tr('Pricing stored successfully.'));
        }
        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    public function processDeleteUserPricing($inputData) {
        $isUserSessionUpdated = false;
        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        
        // get user profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            $this->userRepository->deleteUserPricingData($inputData["item_uid"]);
            $isUserSessionUpdated = true;
        }
        // check if user profile stored or update
        if ($isUserSessionUpdated) {

            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            //get people likes me data
            $userLikedMeData = $this->userRepository->fetchUserLikeMeData();
            //check user like data exists
            if (!__isEmpty($userLikedMeData)) {
                foreach ($userLikedMeData as $userLike) {
                    //notification log message
                    notificationLog($fullName.' that you follow has updated their price. ', route('user.profile_view', ['username' => $userLike->username]), null, $userLike->userId, $userId, 'update-price');

                    //push data to pusher
                    PushBroadcast::notifyViaPusher('event.user.notification', [
                        'type' => 'update-price',
                        'userUid' => $userLike->userUId,
                        'subject' => __tr('User that you follow has updated their price'),
                        'message' => $fullName.__tr(' that you follow has updated their price. '),
                        'messageType' => __tr('success'),
                        'showNotification' => getUserSettings('show_user_login_notification', $userLike->userId),
                        'getNotificationList' => getNotificationList($userLike->userId),
                    ]);
                }
            }
            
            
            $newUserSessionData = $this->userRepository->fetchUserSessionData($userId)->toArray();
            return $this->engineReaction(1, [
                'stored_session_list' => $newUserSessionData,
            ], __tr('Pricing stored successfully.'));
        }
        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    // Setting page

    public function prepareSettingAccountData(){

        $userId = getUserID();
        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        return $this->engineReaction(1, [
            'userData' => $user,
        ], '');
        
    }
    public function processSettingAccount($inputData)
    {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;

            // Prepare User Details
            $userDetails = [
                  'username' => $inputData['username'],
                  'email' => $inputData['email_address'],
              ];

            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($user)) {
                return $this->userSettingRepository->transactionResponse(18, null, __tr('User does not exists.'));
            }

            $userFromEmail = $this->userSettingRepository->fetchUserWithEmail($userId, $inputData['email_address']);
            // Check if user details exists
            if (!\__isEmpty($userFromEmail)) {
                return $this->userSettingRepository->transactionResponse(18, ['userData'=>$user], __tr('This email is already in use.'));
            }

            $userFromUsername = $this->userSettingRepository->fetchUserWithUsername($userId, $inputData['username']);
            // Check if user details exists
            if (!\__isEmpty($userFromUsername)) {
                return $this->userSettingRepository->transactionResponse(18, ['userData'=>$user], __tr('This username is already in use.'));
            }

            // check if user details updated
            if ($this->userSettingRepository->updateUser($user, $userDetails)) {
                activityLog($user->first_name.' '.$user->last_name.' update own user info.');
                $isBasicSettingsUpdated = true;
            }

            // Prepare User profile details
            $userProfileDetails = [
                  'kanji_name' => array_get($inputData, 'fullname_kanji'),
                  'kata_name' => array_get($inputData, 'fullname_katagana'),
                  'dob' => array_get($inputData, 'birthday'),
              ];

            // get user profile
            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            // check if user profile exists
            if (\__isEmpty($userProfile)) {
                $userProfileDetails['user_id'] = $userId;
                if ($this->userSettingRepository->storeUserProfile($userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' store own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            } else {
                if ($this->userSettingRepository->updateUserProfile($userProfile, $userProfileDetails)) {
                    activityLog($user->first_name.' '.$user->last_name.' update own user profile.');
                    $isBasicSettingsUpdated = true;
                }
            }

            $user = $this->userSettingRepository->fetchUserDetails($userId);
            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, ['userData'=>$user], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, ['userData'=>$user], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function processSettingPrivacy($inputData) {
        $transactionResponse = $this->userSettingRepository->processTransaction(function () use ($inputData) {
            $isBasicSettingsUpdated = false;
            $userId = getUserID();
            $user = $this->userSettingRepository->fetchUserDetails($userId);
            // Check if user details exists
            if (\__isEmpty($user)) {
                return $this->userSettingRepository->transactionResponse(18, null, __tr('User does not exist.'));
            }

            // check if user details updated
            if ($this->userSettingRepository->updatePasswordUser($user, $inputData['password'])) {
                activityLog($user->first_name.' '.$user->last_name.' update own user info.');
                $isBasicSettingsUpdated = true;
            }

            if ($isBasicSettingsUpdated) {
                return $this->userSettingRepository->transactionResponse(1, [], __tr('Your basic information updated successfully.'));
            }
            // // Send failed server error message
            return $this->userSettingRepository->transactionResponse(2, [], __tr('Something went wrong on server.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function preparePremiumPlanStripeUserData()
    {
        $premiumPlanCollection = getStoreSettings('plan_duration');
        $premiumFeaturesCollection = getStoreSettings('feature_plans');
        $premiumPlans = $premiumPlanData = $premiumFeatureData = [];

        // check if user premium plan exists
        if (!__isEmpty($premiumPlanCollection)) {
            $premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
            $planDurationConfig = config('__settings.items.premium-plans');
            $defaultPlanDuration = $planDurationConfig['plan_duration']['default'];
            $premiumPlanData = combineArray($defaultPlanDuration, $premiumPlans);
        }

        // check if user premium features exists
        if (!__isEmpty($premiumFeaturesCollection)) {
            $premiumFeature = is_array($premiumFeaturesCollection) ? $premiumFeaturesCollection : json_decode($premiumFeaturesCollection, true);
            // Get settings from config
            $featurePlanConfig = config('__settings.items.premium-feature');
            $defaultFeaturePlans = $featurePlanConfig['feature_plans']['default'];
            $premiumFeatureData = combineArray($defaultFeaturePlans, $premiumFeature);
        }

        $userSubscription = $this->userSettingRepository->fetchUserSubscriptionStripe(getUserID());

        $userSubscriptionData = [];
        if (!__isEmpty($userSubscription) and !__isEmpty($premiumPlans) and !__isEmpty($premiumPlanData)) {
            
            // $planData = $premiumPlanData[$userSubscription->plan_id];
            // $expiryAt = isset($userSubscription->expiry_at) ? formatDate($userSubscription->expiry_at, 'l jS F Y H:i:s') : 'N/A';

            $next_payment_date = "";
            $card_type = "";
            $card_last4 = "";
            $card_icon = "credit-card";
            try {
                Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
                $customer = \Stripe\Customer::retrieve($userSubscription->stripe_customer_id);
                $subscription = $customer->subscriptions->retrieve($userSubscription->stripe_subscription_id);
                $next_payment_date = Carbon::parse($subscription->current_period_end)->format('j F Y');
                if($subscription->status == 'trialing'){
                    $next_payment_date = Carbon::parse($subscription->trial_end)->format('j F Y');
                }

                $card = $customer->sources->data[0];
                //$card = $customer->active_card;
                $card_last4 = $card->last4; // last4, type, exp_month, exp_year, 
                $card_type = $card->brand;
                 //  Visa, Mastercard, American Express, Discover, JCB, Diners Club, China UnionPay, debit cards.
                 // American Express, Diners Club, Discover, JCB, MasterCard, UnionPay, Visa, or Unknown
                switch($card_type){
                    case "Visa":
                        $card_icon = "visa";
                        break; 
                    case "American Express":
                        $card_icon = "amex";
                        break;
                    case "Mastercard":
                        $card_icon = "mastercard";
                        break;
                    case "Discover":
                        $card_icon = "discover";
                        break;
                    case "JCB":
                        $card_icon = "jcb";
                        break;
                    case "Diners Club":
                        $card_icon = "diners-club";
                        break;
                    default:
                        $card_icon = "credit-card";
                        break;
                }
                
            } catch (Exception $e) {

            }

            $userSubscriptionData = [
                "_id" => $userSubscription->_id,
                "_uid" => $userSubscription->_uid,
                "created_at" => formatDate($userSubscription->created_at, 'l jS F Y H:i:s'),
                "users__id" => $userSubscription->users__id,
                //"expiry_at" => $expiryAt,
                //"credit_wallet_transactions__id" => $userSubscription->credit_wallet_transactions__id,
                //"debitedCredits" => $userSubscription->credits,
                //"plan_id" => $userSubscription->plan_id,
                //"planTitle" => $planData['title'],
                'start_date' => Carbon::parse($userSubscription->created)->format('j F Y'),
                "planTitle" => $userSubscription->plan_interval,
                'planPrice' => $userSubscription->plan_amount,
                'next_payment_date'  => $next_payment_date,
                'plan_period_end'  => $userSubscription->plan_period_end,
                'status'  => $userSubscription->status,
                'card_type'         => $card_type,
                'card_last4'        => $card_last4,
                'card_icon'         => $card_icon,
                'membership'        => $userSubscription->membership
            ];
        }

        return $this->engineReaction(1, [
            'premiumPlanData' => [
                'isPremiumUser'         => isPremiumUserStripe(),
                'userSubscriptionData'     => $userSubscriptionData,
                'premiumPlans'             => $premiumPlanData,
                'premiumFeature'         => $premiumFeatureData
            ]
        ]);
    }

    public function processUserSubscription($inputData) {

            // Get user ID from current SESSION 
            $userID = getUserID(); 
            $isUpdated = false;

            $payment_id = $statusMsg = $api_error = ''; 
            $ordStatus = 'error'; 
            
            // pt_membership_type , "standard", "premium"

            // Check whether stripe token is not empty 
            if(!__isEmpty($inputData['plan_id']) && isset($inputData['stripeToken']) && !__isEmpty($inputData['stripeToken'])){ 
                
                // Retrieve stripe token and user info from the submitted form data 
                $token  = $inputData['stripeToken']; 
                $name = $inputData['custName']; 
                $email = $inputData['custEmail']; 
                
                // Plan info 
                $planID = $inputData['plan_id']; 
                $membership = isset($inputData['membership'])? $inputData['membership']:"";

                $premiumPlanCollection = getStoreSettings('plan_duration');
                $premiumPlans = $premiumPlanData = $premiumFeatureData = [];

                // check if user premium plan exists
                if (!__isEmpty($premiumPlanCollection)) {
                    $premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
                    $planDurationConfig = config('__settings.items.premium-plans');
                    $defaultPlanDuration = $planDurationConfig['plan_duration']['default'];
                    $premiumPlanData = combineArray($defaultPlanDuration, $premiumPlans);
                }
                
                $planInfo = $premiumPlanData[$membership][$planID]; 
                $planName = $planInfo['title']; 
                $planPrice = $planInfo['price']; 
                $planInterval = $planID;  // week , month , year
                
                // switch ($inputData['select_plan']) {
                //     case 'one_day':
                //         $expiryTime = $currentDateTime->add(1, 'day');
                //         break;
                //     case 'one_week':
                //         $expiryTime = $currentDateTime->add(7, 'day');
                //         break;
                //     case 'one_month':
                //         $expiryTime = $currentDateTime->addMonths(1);
                //         break;
                //     case 'half_year':
                //         $expiryTime = $currentDateTime->addMonths(6);
                //         break;
                //     case 'life_time':
                //         $expiryTime = $currentDateTime->addYears(100);
                //         break;
                // }

                switch ($planID) {
                    case 'one_day':
                        $planInterval = 'day';
                        break;
                    case 'one_week':
                        $planInterval = 'week';
                        break;
                    case 'one_month':
                        $planInterval = 'month';
                        break;
                }
                
                if (getStoreSettings('use_test_stripe')) {
                    $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
                } else {
                    $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
                }
        
                // //set Stripe Api Secret Key in Stripe static method object
                //Stripe::setApiKey($stripeSecretKey);
                
                // Set API key 
                Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
                
                // Add customer to stripe 
                try {  
                    $customer = \Stripe\Customer::create(array( 
                        'email' => $email, 
                        'source'  => $token, 
                        'name'   => $name,
                        // ,'plan'     => $stripePlan, 'name' => 'Ed Ward', 
                        // 'account_balance' => $setupFee,
                        // 'description' => "Charge with one time setup fee"
                    ));

                }catch(Exception $e) {  
                    $api_error = $e->getMessage();  
                } 
                
                if(empty($api_error) && $customer){  
                    // Convert price to cents 
                    $priceCents = round($planPrice*100); 
                    // Create a plan 
                    try { 
                        $plan = \Stripe\Plan::create(array( 
                            "product" => [ 
                                "name" => $planName 
                            ], 
                            "amount" => $planPrice, // $priceCents, 
                            "currency" => getStoreSettings('currency'), 
                            "interval" => $planInterval, 
                            "interval_count" => 1 
                        )); 
                    }catch(Exception $e) { 
                        $api_error = $e->getMessage(); 
                    } 
                    
                    if(empty($api_error) && $plan){ 
                        // Creates a new subscription 
                        try { 
                            $subscription_data = array( 
                                "customer" => $customer->id, 
                                "items" => array( 
                                    array( 
                                        "plan" => $plan->id, 
                                    ), 
                                ), 
                                //"trial_period_days" => 30,
                                //'trial_end' => 1536048827,
                                // "cancel_at" => $cancelAt  // -  $cancelAt = strtotime('+30 day', time());
                            );
                            if($membership != 'premium'){

                                $userSubscription = getUserSubscriptionStripe();
                                if(is_null($userSubscription))
                                    $subscription_data["trial_period_days"] = 30;

                            }
                            $subscription = \Stripe\Subscription::create($subscription_data); 
                        }catch(Exception $e) { 
                            $api_error = $e->getMessage(); 
                        } 
                        
                        if(empty($api_error) && $subscription){ 
                            // Retrieve subscription data 
                            $subsData = $subscription->jsonSerialize(); 
                    
                            // Check whether the subscription activation is successful 
                          //  if($subsData['status'] == 'active'){ 
                                // Subscription info 
                                $subscrID = $subsData['id']; 
                                $custID = $subsData['customer']; 
                                $planID = $subsData['plan']['id']; 
                                $planAmount =  ($subsData['plan']['amount']);  // ($subsData['plan']['amount']/100); 
                                $planCurrency = $subsData['plan']['currency']; 
                                $planinterval = $subsData['plan']['interval']; 
                                $planIntervalCount = $subsData['plan']['interval_count']; 
                                $created = date("Y-m-d H:i:s", $subsData['created']); 
                                
                                $current_period_start = date("Y-m-d H:i:s", $subsData['current_period_start']); 
                                $current_period_end = date("Y-m-d H:i:s", $subsData['current_period_end']); 
                                $status = $subsData['status']; 
                                $trial_end = $subsData['trial_end'];
                                $trial_start = $subsData['trial_start'];
                                                                
                                $userSubscriptionDetails = [
                                    'stripe_subscription_id' => $subscrID,
                                    'stripe_customer_id'  => $custID,
                                    'stripe_plan_id'  => $planID,
                                    'plan_amount'  => $planAmount,
                                    'plan_amount_currency'  => $planCurrency,
                                    'plan_interval'  => $planinterval,
                                    'plan_interval_count'  => $planIntervalCount,
                                    'payer_email'  => $email,
                                    'created'  => $created,
                                    'membership'  => $membership,
                                    'plan_period_start' => null,
                                    'plan_period_end'   => null
                                ];

                                // get user profile
                                $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripe($userID);

                                // check if user profile exists
                                if (\__isEmpty($userSubscriptionStripe)) {
                                    $userSubscriptionDetails['users__id'] = $userID;
                                    if ($this->userSettingRepository->storeUserSubscriptionStripe($userSubscriptionDetails)) {
                                        //activityLog($user->first_name.' '.$user->last_name.' subscribed via stripe.');
                                        $isUpdated = true;
                                    }
                                } else {
                                    if ($this->userSettingRepository->updateUserSubscriptionStripe($userSubscriptionStripe, $userSubscriptionDetails)) {
                                        //activityLog($user->first_name.' '.$user->last_name.' update subscription of stripe.');
                                        $isUpdated = true;
                                    }
                                }
                                $ordStatus = $subsData['status']; 
                                $statusMsg = 'Your Subscription Payment has been done as '.$subsData['status']; 
                            //}else{ 
                            //    $statusMsg = "Subscription activation failed!"; 
                            //} 
                        }else{ 
                            $statusMsg = "Subscription creation failed! ".$api_error; 
                        } 
                    }else{ 
                        $statusMsg = "Plan creation failed! ".$api_error; 
                    } 
                }else{  
                    $statusMsg = "Invalid card details! $api_error";  
                } 
            }else{ 
                $statusMsg = "Error on form submission, please try again."; 
            } 

            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr($statusMsg));

            /*
            <div class="container">
                <div class="status">
                    <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>
                    <?php if(!empty($subscrID)){ ?>
                        <h4>Payment Information</h4>
                        <p><b>Reference Number:</b> <?php echo $subscription_id; ?></p>
                        <p><b>Transaction ID:</b> <?php echo $subscrID; ?></p>
                        <p><b>Amount:</b> <?php echo $planAmount.' '.$planCurrency; ?></p>
                        
                        <h4>Subscription Information</h4>
                        <p><b>Plan Name:</b> <?php echo $planName; ?></p>
                        <p><b>Amount:</b> <?php echo $planPrice.' '.$currency; ?></p>
                        <p><b>Plan Interval:</b> <?php echo $planInterval; ?></p>
                        <p><b>Period Start:</b> <?php echo $current_period_start; ?></p>
                        <p><b>Period End:</b> <?php echo $current_period_end; ?></p>
                        <p><b>Status:</b> <?php echo $status; ?></p>
                    <?php } ?>
                </div>
                <a href="index.php" class="btn-link">Back to Subscription Page</a>
            </div>
            */

    }

    public function processUserCancelSubscription() {

        Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
        $userId = getUserID();
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripe($userId);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {
            $api_error = "";
            $result = [];
            $current_period_end = null;
            try { 
                $subscription = \Stripe\Subscription::retrieve($userSubscriptionStripe->stripe_subscription_id);
                if( !\__isEmpty( $subscription ) ){ 

                    $subsData = $subscription->jsonSerialize(); 
                    $current_period_start = date("Y-m-d H:i:s", $subsData['current_period_start']); 
                    $current_period_end = date("Y-m-d H:i:s", $subsData['current_period_end']); 
                    $status = $subsData['status'];  // active , canceled , trialing ...
                    $trial_end = $subsData['trial_end'];
                    $trial_start = $subsData['trial_start'];
                    
                    if($status == 'active'){
                        //$result = $subscription->cancel();  //        

                        $result = \Stripe\Subscription::update($userSubscriptionStripe->stripe_subscription_id, array(
                            'cancel_at_period_end' => true
                        ));
                        
                    } else {
                        $result = $subscription->cancel();
                        $current_period_end =  Carbon::now();
                    }
                    
                    /*
                        Stripe\Subscription Object ( [id] => sub_1KJUSNARq1SX5EYaHNytTfZd [object] => subscription [application_fee_percent] => [automatic_tax] => Stripe\StripeObject Object ( [enabled] => ) [billing_cycle_anchor] => 1642561411 [billing_thresholds] => [cancel_at] => [cancel_at_period_end] => [canceled_at] => 1642561473 [collection_method] => charge_automatically [created] => 1642561411 [current_period_end] => 1645239811 [current_period_start] => 1642561411 [customer] => cus_KzTPFLPQaF8I5G [days_until_due] => [default_payment_method] => [default_source] => [default_tax_rates] => Array ( ) [discount] => [ended_at] => 1642561473 [items] => Stripe\Collection Object ( [object] => list [data] => Array ( [0] => Stripe\SubscriptionItem Object ( [id] => si_KzTPm7zAP5fDHI [object] => subscription_item [billing_thresholds] => [created] => 1642561412 [metadata] => Stripe\StripeObject Object ( ) [plan] => Stripe\Plan Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => plan [active] => 1 [aggregate_usage] => [amount] => 500 [amount_decimal] => 500 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [interval] => month [interval_count] => 1 [livemode] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [tiers] => [tiers_mode] => [transform_usage] => [trial_period_days] => [usage_type] => licensed ) [price] => Stripe\Price Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => price [active] => 1 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [livemode] => [lookup_key] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [recurring] => Stripe\StripeObject Object ( [aggregate_usage] => [interval] => month [interval_count] => 1 [trial_period_days] => [usage_type] => licensed ) [tax_behavior] => unspecified [tiers_mode] => [transform_quantity] => [type] => recurring [unit_amount] => 500 [unit_amount_decimal] => 500 ) [quantity] => 1 [subscription] => sub_1KJUSNARq1SX5EYaHNytTfZd [tax_rates] => Array ( ) ) ) [has_more] => [total_count] => 1 [url] => /v1/subscription_items?subscription=sub_1KJUSNARq1SX5EYaHNytTfZd ) [latest_invoice] => in_1KJUSNARq1SX5EYaYnqSsJ6N [livemode] => [metadata] => Stripe\StripeObject Object ( ) [next_pending_invoice_item_invoice] => [pause_collection] => [payment_settings] => Stripe\StripeObject Object ( [payment_method_options] => [payment_method_types] => ) [pending_invoice_item_interval] => [pending_setup_intent] => [pending_update] => [plan] => Stripe\Plan Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => plan [active] => 1 [aggregate_usage] => [amount] => 500 [amount_decimal] => 500 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [interval] => month [interval_count] => 1 [livemode] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [tiers] => [tiers_mode] => [transform_usage] => [trial_period_days] => [usage_type] => licensed ) [quantity] => 1 [schedule] => [start_date] => 1642561411 [status] => canceled [tax_percent] => [transfer_data] => [trial_end] => [trial_start] => )
                    */
                }
                
            }catch(Exception $e) { 
                $api_error = $e->getMessage(); 
            } 
            if(empty($api_error)){ 

                $this->processUserCancelSubscriptionSponser();

                $this->userSettingRepository->updateUserSubscriptionStripe($userSubscriptionStripe,
                    [ 
                        "status"    =>  2, // stop subscription 
                        "plan_period_end"   => $current_period_end,
                    ]
                );
                $isUpdated = true;
                return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$result ], __tr("Your subscription cancelled successfully."));
            }
            return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$api_error ], __tr("Your subscription cancell failed."));
        }
        
    }

    public function processUserSubscriptionUpdateCard($inputData) {

        // Get user ID from current SESSION 
        $userID = getUserID(); 
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripe($userID);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {

            $payment_id = $statusMsg = $api_error = ''; 
            $ordStatus = 'error'; 
            
            // pt_membership_type , "standard", "premium"
    
            // Check whether stripe token is not empty 
            if( isset($inputData['stripeToken']) && !__isEmpty($inputData['stripeToken'])){ 
                
                // Retrieve stripe token and user info from the submitted form data 
                $token  = $inputData['stripeToken']; 
                $name = $inputData['custName']; 
                $email = $inputData['custEmail'];
                 if (getStoreSettings('use_test_stripe')) {
                    $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
                } else {
                    $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
                }
                // //set Stripe Api Secret Key in Stripe static method object
                //Stripe::setApiKey($stripeSecretKey);
                
                // Set API key 
                Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 

                // Add customer to stripe 
                try {  
                    
                    $customer = \Stripe\Customer::retrieve($userSubscriptionStripe->stripe_customer_id);
                    $new_card = $customer->sources->create(array(
                        'source'  => $token, 
                    ));
                    $customer->email = $email;
                    $customer->name = $name;
                    $customer->default_source = $new_card->id;
                    $customer->save();
    
                }catch(Exception $e) {  
                    $api_error = $e->getMessage();  
                } 
                
                if(empty($api_error) && $customer){  
                    $isUpdated = true;
                    return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("Your card updated successfully."));

                }else{  
                    $statusMsg = "Invalid card details! $api_error";  
                } 
            }else{ 
                $statusMsg = "Error on form submission, please try again."; 
            } 
    
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr($statusMsg));
        }
    }

    public function processUserSubscriptionDowngrade() {
        $userId = getUserID();
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripe($userId);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {
            $premiumPlanCollection = getStoreSettings('plan_duration');
            $premiumPlans = $premiumPlanData = $premiumFeatureData = [];
            // check if user premium plan exists
            if (!__isEmpty($premiumPlanCollection)) {
                $premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
                $planDurationConfig = config('__settings.items.premium-plans');
                $defaultPlanDuration = $planDurationConfig['plan_duration']['default'];
                $premiumPlanData = combineArray($defaultPlanDuration, $premiumPlans);
            }
            $planInterval     = $userSubscriptionStripe->plan_interval;
            $membership = 'standard';
            $planID = $planInterval;  // week , month , year , consider plan_interval_count for ex, 7 days,  6 months
            switch ($planInterval) {
                case 'day':
                    $planID = 'one_day';
                    break;
                case 'week':
                    $planID = 'one_week';
                    break;
                case 'month':
                    $planID = 'one_month';
                    break;
            }
            $planInfo = $premiumPlanData[$membership][$planID]; 
            $planName = $planInfo['title']; 
            $planPrice = $planInfo['price']; 
            
            if (getStoreSettings('use_test_stripe')) {
                $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
            } else {
                $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
            }
            // //set Stripe Api Secret Key in Stripe static method object
            //Stripe::setApiKey($stripeSecretKey);
            // Set API key 
            Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
            
            $api_error = "";
            $result = [];

            try { 
                $plan = \Stripe\Plan::create(array( 
                    "product" => [ 
                        "name" => $planName 
                    ], 
                    "amount" => $planPrice, // $priceCents, 
                    "currency" => getStoreSettings('currency'), 
                    "interval" => $planInterval, 
                    "interval_count" => 1 
                )); 
            }catch(Exception $e) { 
                $api_error = $e->getMessage(); 
            } 

            if(empty($api_error) && $plan)
            {
                try {
                    $subscription = \Stripe\Subscription::retrieve($userSubscriptionStripe->stripe_subscription_id);
                    // Change Plan
                    $charge = \Stripe\Subscription::update($userSubscriptionStripe->stripe_subscription_id, [
                        'cancel_at_period_end' => false,
                        'proration_behavior' => 'create_prorations',
                        'billing_cycle_anchor' => 'unchanged',
                        'items' => [
                            [
                                'id' => $subscription->items->data[0]->id,
                                'price' => $plan->id,
                            ],
                        ],
                    ]);


                    // $subscription_data = array( 
                    //     "items" => array( 
                    //         array( 
                    //             "plan" => $plan->id, 
                    //         ), 
                    //     ), 
                    //     //"trial_period_days" => 30,
                    //     //'trial_end' => 1536048827,
                    //     // "cancel_at" => $cancelAt  // -  $cancelAt = strtotime('+30 day', time());
                    // );

                    /*

                        // Retrieve the customer:
                        $customer = Stripe_Customer::retrieve($customer_id);
                        
                        // Retrieve the subscription being updated:
                        $subscription = $customer->subscriptions->retrieve($subscription_id);
                        
                        // Change the plan:
                        $subscription->plan = '25_monthly'; // Was 10_monthly
                        
                        // Use proration (default; not required):
                        $subscription->prorate = true;
                        
                        // Save the changes:
                        $subscription->save();

                        // Invoice now:
                        Stripe_Invoice::create(array(
                            'customer' => $customer_id
                        ));
                    */
                    //if($membership != 'premium'){
                        //$subscription_data["trial_period_days"] = 30;
                    //}
                    //\Stripe\Subscription::update($userSubscriptionStripe->stripe_subscription_id, $subscription_data);
    
                } catch (Exception $e) {
                    $api_error = $e->getMessage();
                }

                if (empty($api_error)) {
                    $result = $this->userSettingRepository->updateUserSubscriptionStripe($userSubscriptionStripe, [
                            "membership"=> $membership ,
                            'stripe_plan_id'=>$plan->id, 
                            'plan_amount'=>$planPrice
                        ]);
                    $isUpdated = true;
                    return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$result ], __tr("Your subscription downgraded successfully."));
                } 
            } 
            return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$api_error ], __tr("Your subscription downgrade failed."));
        }
    }

    public function processUserSubscriptionUpgrade() {
        $userId = getUserID();
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripe($userId);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {
            $premiumPlanCollection = getStoreSettings('plan_duration');
            $premiumPlans = $premiumPlanData = $premiumFeatureData = [];
            // check if user premium plan exists
            if (!__isEmpty($premiumPlanCollection)) {
                $premiumPlans = is_array($premiumPlanCollection) ? $premiumPlanCollection : json_decode($premiumPlanCollection, true);
                $planDurationConfig = config('__settings.items.premium-plans');
                $defaultPlanDuration = $planDurationConfig['plan_duration']['default'];
                $premiumPlanData = combineArray($defaultPlanDuration, $premiumPlans);
            }
            $planInterval     = $userSubscriptionStripe->plan_interval;
            $membership = 'premium';
            $planID = $planInterval;  // week , month , year , consider plan_interval_count for ex, 7 days,  6 months
            switch ($planInterval) {
                case 'day':
                    $planID = 'one_day';
                    break;
                case 'week':
                    $planID = 'one_week';
                    break;
                case 'month':
                    $planID = 'one_month';
                    break;
            }
            $planInfo = $premiumPlanData[$membership][$planID]; 
            $planName = $planInfo['title']; 
            $planPrice = $planInfo['price']; 
            
            if (getStoreSettings('use_test_stripe')) {
                $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
            } else {
                $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
            }
            // //set Stripe Api Secret Key in Stripe static method object
            //Stripe::setApiKey($stripeSecretKey);
            // Set API key 
            Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
            
            $api_error = "";
            $result = [];

            try { 
                $plan = \Stripe\Plan::create(array( 
                    "product" => [ 
                        "name" => $planName 
                    ], 
                    "amount" => $planPrice, // $priceCents, 
                    "currency" => getStoreSettings('currency'), 
                    "interval" => $planInterval, 
                    "interval_count" => 1 
                )); 
            }catch(Exception $e) { 
                $api_error = $e->getMessage(); 
            } 

            if(empty($api_error) && $plan)
            {
                try {
                    //$subscription = \Stripe\Subscription::retrieve($userSubscriptionStripe->stripe_subscription_id);
    
                    // $subscription_data = array( 
                    //     "items" => array( 
                    //         array( 
                    //             "plan" => $plan->id, 
                    //         ), 
                    //     ), 
                    //     //"trial_period_days" => 30,
                    //     //'trial_end' => 1536048827,
                    //     // "cancel_at" => $cancelAt  // -  $cancelAt = strtotime('+30 day', time());
                    // );
                    // if($membership != 'premium'){
                    //     $subscription_data["trial_period_days"] = 30;
                    // }
                    // \Stripe\Subscription::update($userSubscriptionStripe->stripe_subscription_id, $subscription_data);

                    $subscription = \Stripe\Subscription::retrieve($userSubscriptionStripe->stripe_subscription_id);
                    // Change Plan
                    $charge = \Stripe\Subscription::update($userSubscriptionStripe->stripe_subscription_id, [
                        'cancel_at_period_end' => false,
                        'proration_behavior' => 'create_prorations',
                        'billing_cycle_anchor' => 'unchanged',
                        'items' => [
                            [
                                'id' => $subscription->items->data[0]->id,
                                'price' => $plan->id,
                            ],
                        ],
                    ]);
    
                } catch (Exception $e) {
                    $api_error = $e->getMessage();
                }

                if (empty($api_error)) {
                    $result = $this->userSettingRepository->updateUserSubscriptionStripe($userSubscriptionStripe, 
                        [
                            "membership"=> $membership,
                            'stripe_plan_id'=>$plan->id, 
                            'plan_amount'=>$planPrice
                        ]);
                    $isUpdated = true;
                    return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$result ], __tr("Your subscription upgraded successfully."));
                } 
            } 
            return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$api_error ], __tr("Your subscription upgrade failed."));
        }
    }

    public function processUserSubscriptionSponser($inputData) {

        // Get user ID from current SESSION 
        $userID = getUserID(); 
        $isUpdated = false;

        $payment_id = $statusMsg = $api_error = ''; 
        $ordStatus = 'error'; 
        
        // pt_membership_type , "standard", "premium"

        // Check whether stripe token is not empty 
        if(!__isEmpty($inputData['plan_id']) && isset($inputData['stripeToken']) && !__isEmpty($inputData['stripeToken'])){ 
            
            // Retrieve stripe token and user info from the submitted form data 
            $token  = $inputData['stripeToken']; 
            $name = $inputData['custName']; 
            $email = $inputData['custEmail']; 
            
            // Plan info 
            $planID = $inputData['plan_id'];  // half_year, quarter_year , one_month
            $pricing_id = isset($inputData['pricing_id'])? $inputData['pricing_id']:"";

            $promotionPlanCollection = getStoreSettings('promotion_plan_duration');
            $promotionPlans = $promotionPlanData = [];

            // check if user premium plan exists
            if (!__isEmpty($promotionPlanCollection)) {
                $promotionPlans = is_array($promotionPlanCollection) ? $promotionPlanCollection : json_decode($promotionPlanCollection, true);
                $planDurationConfig = config('__settings.items.promotion-plans');
                $defaultPlanDuration = $planDurationConfig['promotion_plan_duration']['default'];
                $promotionPlanData = combineArray($defaultPlanDuration, $promotionPlans);
            }
            
            $planInfo = $promotionPlanData['sponser'][$planID]; 
            $planName = $planInfo['title']; 
            $planPrice = $planInfo['price']; 
            $planInterval = $planInfo['plan'];
            $planIntervalCount = $planInfo['interval'];
            
            if (getStoreSettings('use_test_stripe')) {
                $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
            } else {
                $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
            }
    
            // //set Stripe Api Secret Key in Stripe static method object
            //Stripe::setApiKey($stripeSecretKey);
            
            // Set API key 
            Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
            
            // Add customer to stripe 
            try {  
                $customer = \Stripe\Customer::create(array( 
                    'email' => $email, 
                    'source'  => $token, 
                    'name'   => $name,
                    // ,'plan'     => $stripePlan, 'name' => 'Ed Ward', 
                    // 'account_balance' => $setupFee,
                    // 'description' => "Charge with one time setup fee"
                ));

            }catch(Exception $e) {  
                $api_error = $e->getMessage();  
            } 
            
            if(empty($api_error) && $customer){  
                // Convert price to cents 
                $priceCents = round($planPrice*100); 
                // Create a plan 
                try { 
                    $plan = \Stripe\Plan::create(array( 
                        "product" => [ 
                            "name" => $planName 
                        ], 
                        "amount" => $planPrice, // $priceCents, 
                        "currency" => getStoreSettings('currency'), 
                        "interval" => $planInterval, 
                        "interval_count" => $planIntervalCount 
                    )); 
                }catch(Exception $e) { 
                    $api_error = $e->getMessage(); 
                } 
                
                if(empty($api_error) && $plan){ 
                    // Creates a new subscription 
                    try { 
                        $subscription_data = array( 
                            "customer" => $customer->id, 
                            "items" => array( 
                                array( 
                                    "plan" => $plan->id, 
                                ), 
                            ), 
                            //"trial_period_days" => 30,
                            //'trial_end' => 1536048827,
                            // "cancel_at" => $cancelAt  // -  $cancelAt = strtotime('+30 day', time());
                        );

                        $subscription = \Stripe\Subscription::create($subscription_data); 

                    }catch(Exception $e) { 
                        $api_error = $e->getMessage(); 
                    } 
                    
                    if(empty($api_error) && $subscription){ 
                        // Retrieve subscription data 
                        $subsData = $subscription->jsonSerialize(); 
                
                        // Check whether the subscription activation is successful 
                      //  if($subsData['status'] == 'active'){ 
                            // Subscription info 
                            $subscrID = $subsData['id']; 
                            $custID = $subsData['customer']; 
                            $planID = $subsData['plan']['id']; 
                            $planAmount =  ($subsData['plan']['amount']);  // ($subsData['plan']['amount']/100); 
                            $planCurrency = $subsData['plan']['currency']; 
                            $planinterval = $subsData['plan']['interval']; 
                            $planIntervalCount = $subsData['plan']['interval_count']; 
                            $created = date("Y-m-d H:i:s", $subsData['created']); 
                            
                            $current_period_start = date("Y-m-d H:i:s", $subsData['current_period_start']); 
                            $current_period_end = date("Y-m-d H:i:s", $subsData['current_period_end']); 
                            $status = $subsData['status']; 
                            $trial_end = $subsData['trial_end'];
                            $trial_start = $subsData['trial_start'];
                                                            
                            $userSubscriptionDetails = [
                                'stripe_subscription_id' => $subscrID,
                                'stripe_customer_id'  => $custID,
                                'stripe_plan_id'  => $planID,
                                'plan_amount'  => $planAmount,
                                'plan_amount_currency'  => $planCurrency,
                                'plan_interval'  => $planinterval,
                                'plan_interval_count'  => $planIntervalCount,
                                'payer_email'  => $email,
                                'created'  => $created,
                                'user_pricing_id'  => $pricing_id ,
                                'plan_period_start' => null,
                                'plan_period_end'   => null
                            ];

                            // get user profile
                            $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripeSponser($userID);

                            // check if user profile exists
                            if (\__isEmpty($userSubscriptionStripe)) {
                                $userSubscriptionDetails['users__id'] = $userID;
                                if ($this->userSettingRepository->storeUserSubscriptionStripeSponser($userSubscriptionDetails)) {
                                    //activityLog($user->first_name.' '.$user->last_name.' subscribed via stripe.');
                                    $isUpdated = true;
                                }
                            } else {
                                if ($this->userSettingRepository->updateUserSubscriptionStripeSponser($userSubscriptionStripe, $userSubscriptionDetails)) {
                                    //activityLog($user->first_name.' '.$user->last_name.' update subscription of stripe.');
                                    $isUpdated = true;
                                }
                            }
                            $ordStatus = $subsData['status']; 
                            $statusMsg = 'Your Subscription Payment has been done as '.$subsData['status']; 
                        //}else{ 
                        //    $statusMsg = "Subscription activation failed!"; 
                        //} 
                    }else{ 
                        $statusMsg = "Subscription creation failed! ".$api_error; 
                    } 
                }else{ 
                    $statusMsg = "Plan creation failed! ".$api_error; 
                } 
            }else{  
                $statusMsg = "Invalid card details! $api_error";  
            } 
        }else{ 
            $statusMsg = "Error on form submission, please try again."; 
        } 

        return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr($statusMsg));

    }

    public function processUserCancelSubscriptionSponser() {

        Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
        $userId = getUserID();
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripeSponser($userId);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {
            $api_error = "";
            $result = [];
            try { 
                $subscription = \Stripe\Subscription::retrieve($userSubscriptionStripe->stripe_subscription_id);
                $result = $subscription->cancel();  //         $subscription->cancel(['at_period_end' => true]);
                
                /*
                    Stripe\Subscription Object ( [id] => sub_1KJUSNARq1SX5EYaHNytTfZd [object] => subscription [application_fee_percent] => [automatic_tax] => Stripe\StripeObject Object ( [enabled] => ) [billing_cycle_anchor] => 1642561411 [billing_thresholds] => [cancel_at] => [cancel_at_period_end] => [canceled_at] => 1642561473 [collection_method] => charge_automatically [created] => 1642561411 [current_period_end] => 1645239811 [current_period_start] => 1642561411 [customer] => cus_KzTPFLPQaF8I5G [days_until_due] => [default_payment_method] => [default_source] => [default_tax_rates] => Array ( ) [discount] => [ended_at] => 1642561473 [items] => Stripe\Collection Object ( [object] => list [data] => Array ( [0] => Stripe\SubscriptionItem Object ( [id] => si_KzTPm7zAP5fDHI [object] => subscription_item [billing_thresholds] => [created] => 1642561412 [metadata] => Stripe\StripeObject Object ( ) [plan] => Stripe\Plan Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => plan [active] => 1 [aggregate_usage] => [amount] => 500 [amount_decimal] => 500 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [interval] => month [interval_count] => 1 [livemode] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [tiers] => [tiers_mode] => [transform_usage] => [trial_period_days] => [usage_type] => licensed ) [price] => Stripe\Price Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => price [active] => 1 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [livemode] => [lookup_key] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [recurring] => Stripe\StripeObject Object ( [aggregate_usage] => [interval] => month [interval_count] => 1 [trial_period_days] => [usage_type] => licensed ) [tax_behavior] => unspecified [tiers_mode] => [transform_quantity] => [type] => recurring [unit_amount] => 500 [unit_amount_decimal] => 500 ) [quantity] => 1 [subscription] => sub_1KJUSNARq1SX5EYaHNytTfZd [tax_rates] => Array ( ) ) ) [has_more] => [total_count] => 1 [url] => /v1/subscription_items?subscription=sub_1KJUSNARq1SX5EYaHNytTfZd ) [latest_invoice] => in_1KJUSNARq1SX5EYaYnqSsJ6N [livemode] => [metadata] => Stripe\StripeObject Object ( ) [next_pending_invoice_item_invoice] => [pause_collection] => [payment_settings] => Stripe\StripeObject Object ( [payment_method_options] => [payment_method_types] => ) [pending_invoice_item_interval] => [pending_setup_intent] => [pending_update] => [plan] => Stripe\Plan Object ( [id] => plan_KzTP1Qr0S9BXPy [object] => plan [active] => 1 [aggregate_usage] => [amount] => 500 [amount_decimal] => 500 [billing_scheme] => per_unit [created] => 1642561411 [currency] => jpy [interval] => month [interval_count] => 1 [livemode] => [metadata] => Stripe\StripeObject Object ( ) [nickname] => [product] => prod_KzTPCGG6g0J4tu [tiers] => [tiers_mode] => [transform_usage] => [trial_period_days] => [usage_type] => licensed ) [quantity] => 1 [schedule] => [start_date] => 1642561411 [status] => canceled [tax_percent] => [transfer_data] => [trial_end] => [trial_start] => )
                */
            }catch(Exception $e) { 
                $api_error = $e->getMessage(); 
            } 
            if(empty($api_error)){ 
                $this->userSettingRepository->updateUserSubscriptionStripeSponser($userSubscriptionStripe, ["status"=>2]);
                $isUpdated = true;
                return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$result ], __tr("Your subscription cancelled successfully."));
            }
            return $this->engineReaction(1, ['isUpdated' => $isUpdated, 'result'=>$api_error ], __tr("Your subscription cancell failed."));
        }
        
    }

    public function processUserSubscriptionUpdateCardSponser($inputData) {

        // Get user ID from current SESSION 
        $userID = getUserID(); 
        $userSubscriptionStripe = $this->userSettingRepository->fetchUserSubscriptionStripeSponser($userID);
        $isUpdated = false;
        // check if user profile exists
        if (\__isEmpty($userSubscriptionStripe)) {
            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("User does not have own subscription."));
        } else {

            $payment_id = $statusMsg = $api_error = ''; 
            $ordStatus = 'error'; 
            
            // pt_membership_type , "standard", "premium"

            // Check whether stripe token is not empty 
            if( isset($inputData['stripeToken']) && !__isEmpty($inputData['stripeToken'])){ 
                
                // Retrieve stripe token and user info from the submitted form data 
                $token  = $inputData['stripeToken']; 
                $name = $inputData['custName']; 
                $email = $inputData['custEmail'];
                if (getStoreSettings('use_test_stripe')) {
                    $stripeSecretKey = getStoreSettings('stripe_testing_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_testing_publishable_key');
                } else {
                    $stripeSecretKey = getStoreSettings('stripe_live_secret_key');
                    $stripePublishKey = getStoreSettings('stripe_live_publishable_key');
                }
                // //set Stripe Api Secret Key in Stripe static method object
                //Stripe::setApiKey($stripeSecretKey);
                
                // Set API key 
                Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 

                // Add customer to stripe 
                try {  
                    
                    $customer = \Stripe\Customer::retrieve($userSubscriptionStripe->stripe_customer_id);
                    $new_card = $customer->sources->create(array(
                        'source'  => $token, 
                    ));
                    $customer->email = $email;
                    $customer->name = $name;
                    $customer->default_source = $new_card->id;
                    $customer->save();

                }catch(Exception $e) {  
                    $api_error = $e->getMessage();  
                } 
                
                if(empty($api_error) && $customer){  
                    $isUpdated = true;
                    return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr("Your card updated successfully."));

                }else{  
                    $statusMsg = "Invalid card details! $api_error";  
                } 
            }else{ 
                $statusMsg = "Error on form submission, please try again."; 
            } 

            return $this->engineReaction(1, ['isUpdated' => $isUpdated ], __tr($statusMsg));
        }
    }

}
