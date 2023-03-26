<?php

/**
 * UserEngine.php - Main component file.
 *
 * This file is part of the User component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User;

use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Base\BaseMailer;
use App\Yantrana\Components\AbuseReport\Repositories\ManageAbuseReportRepository;
use App\Yantrana\Components\Review\Repositories\ManageReviewRepository;
use App\Yantrana\Components\SupportRequest\Repositories\ManageSupportRequestRepository;
use App\Yantrana\Components\Item\Repositories\ManageItemRepository;
use App\Yantrana\Components\Media\MediaEngine;
use App\Yantrana\Components\User\Repositories\CreditWalletRepository;
use App\Yantrana\Components\User\Repositories\UserEncounterRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;
use App\Yantrana\Components\UserSetting\Repositories\UserSettingRepository;
use App\Yantrana\Support\CommonTrait;
use App\Yantrana\Support\Country\Repositories\CountryRepository;
use App\Yantrana\Support\Utils;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\URL;
use PushBroadcast;
use Session;
use YesSecurity;
use YesTokenAuth;
use Illuminate\Support\Str;
use Stripe\Stripe;

class UserEngine extends BaseEngine
{
    /*
     * @var CommonTrait - Common Trait
     */
    use CommonTrait;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * @var BaseMailer - Base Mailer
     */
    protected $baseMailer;

    /**
     * @var UserSettingRepository - UserSetting Repository
     */
    protected $userSettingRepository;

    /**
     * @var ManageItemRepository - ManageItem Repository
     */
    protected $manageItemRepository;

    /**
     * @var CreditWalletRepository - CreditWallet Repository
     */
    protected $creditWalletRepository;

    /**
     * @var ManageAbuseReportRepository - ManageAbuseReport Repository
     */
    protected $manageAbuseReportRepository;

    /**
     * @var ManageReviewRepository - ManageReview Repository
     */
    protected $manageReviewRepository;
    
    /**
     * @var ManageSupportRequestRepository - ManageSupportRequestRepository 
     */
    protected $manageSupportRequestRepository;
    /**
     * @var UserEncounterRepository - UserEncounter Repository
     */
    protected $userEncounterRepository;

    /**
     * @var CountryRepository - Country Repository
     */
    protected $countryRepository;

    /**
     * @var MediaEngine - Media Engine
     */
    protected $mediaEngine;

    /**
     * Constructor.
     *
     * @param CreditWalletRepository $creditWalletRepository - CreditWallet Repository
     * @param UserRepository         $userRepository         - User Repository
     * @param BaseMailer             $baseMailer             - Base Mailer
     * @param UserSettingRepository  $userSettingRepository  - UserSetting Repository
     * @param ManageItemRepository   $manageItemRepository   - ManageItem Repository
     * @param CountryRepository      $countryRepository      - Country Repository
     *
     *-----------------------------------------------------------------------*/
    public function __construct(
        BaseMailer $baseMailer,
        UserRepository $userRepository,
        UserSettingRepository $userSettingRepository,
        ManageItemRepository $manageItemRepository,
        CreditWalletRepository $creditWalletRepository,
        ManageAbuseReportRepository $manageAbuseReportRepository,
        ManageReviewRepository $manageReviewRepository,
        ManageSupportRequestRepository $manageSupportRequestRepository,
        UserEncounterRepository $userEncounterRepository,
        CountryRepository $countryRepository,
        MediaEngine $mediaEngine
    ) {
        $this->baseMailer = $baseMailer;
        $this->userRepository = $userRepository;
        $this->userSettingRepository = $userSettingRepository;
        $this->manageItemRepository = $manageItemRepository;
        $this->creditWalletRepository = $creditWalletRepository;
        $this->manageAbuseReportRepository = $manageAbuseReportRepository;
        $this->manageReviewRepository = $manageReviewRepository;
        $this->manageSupportRequestRepository = $manageSupportRequestRepository;
        $this->userEncounterRepository = $userEncounterRepository;
        $this->countryRepository = $countryRepository;
        $this->mediaEngine = $mediaEngine;
    }

    /**
     * Process user login request using user repository & return
     * engine reaction.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processLogin($input)
    {
        //check is email or username
        $user = $this->userRepository->fetchByEmailOrUsername($input['email_or_username']);

        // Check if empty then return error message
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('You are not a member of the system, Please go and register first , then you can proceed for login.'));
        }

        //collect login credentials
        $loginCredentials = [
            'email' => $user->email,
            'password' => $input['password'],
        ];

        //check user status not equal to 1
        if ($user->status != 1) {
            return $this->engineReaction(2, ['show_message' => true], __tr('Your account currently __status__, Please contact to administrator.', ['__status__' => configItem('status_codes', $user->status)]));
        }

        //get remember me data
        $remember_me = (isset($input['remember_me']) and $input['remember_me'] == 'on') ? true : false;

        // Process for login attempt
        if (Auth::attempt($loginCredentials, $remember_me)) {
            // Clear login attempts of ip address
            $this->userRepository->clearLoginAttempts();
            //loggedIn user name
            $loggedInUserName = $user->first_name.' '.$user->last_name;

            // //get people likes me data
            // $userLikedMeData = $this->userRepository->fetchUserLikeMeData();
            // //check user like data exists
            // if (!__isEmpty($userLikedMeData)) {
            //     foreach ($userLikedMeData as $userLike) {
            //         //notification log message
            //         notificationLog($loggedInUserName.' is online now. ', route('user.profile_view', ['username' => $user->username]), null, $userLike->userId, $user->_id, 'user-login');

            //         //push data to pusher
            //         PushBroadcast::notifyViaPusher('event.user.notification', [
            //             'type' => 'user-login',
            //             'userUid' => $userLike->userUId,
            //             'subject' => __tr('User Logged In successfully'),
            //             'message' => $loggedInUserName.__tr(' is online now. '),
            //             'messageType' => __tr('success'),
            //             'showNotification' => getUserSettings('show_user_login_notification', $userLike->userId),
            //             'getNotificationList' => getNotificationList($userLike->userId),
            //         ]);
            //     }
            // }


            //if mobile request
            if (isMobileAppRequest()) {
                //issue new token
                $authToken = YesTokenAuth::issueToken([
                    'aud' => $user->_id,
                    'uaid' => $user->user_authority_id,
                ]);

                return $this->engineReaction(1, [
                    'auth_info' => getUserAuthInfo(1),
                    'access_token' => $authToken,
                ], 'Welcome, you are logged in successfully.');
            }

            return $this->engineReaction(1, [
                'auth_info' => getUserAuthInfo(1),
                'intendedUrl' => Session::get('intendedUrl'),
                'show_message' => true,
            ], __tr('Welcome, you are logged in successfully.'));
        }

        // Store every login attempt.
        $this->userRepository->updateLoginAttempts();

        return $this->engineReaction(2, ['show_message' => true], __tr('Authentication failed, please check your credentials & try again.'));
    }

    /**
     * Process logout request.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processLogout()
    {
        if (Session::has('intendedUrl')) {
            Session::forget('intendedUrl');
        }

        if (isset($_SESSION['CURRENT_LOCALE'])) {
            $_SESSION['CURRENT_LOCALE'] = null;
        }

        $userId = Auth::user()->_id;

        //fetch user authority
        $userAuthority = $this->userRepository->fetchUserAuthority($userId);

        //update data
        $updateData = [
            'updated_at' => Carbon::now()->subMinutes(2)->toDateTimeString(),
        ];

        // Check for if new email activation store
        if ((!__isEmpty($userAuthority)) and $this->userRepository->updateUserAuthority($userAuthority, $updateData)) {
            Auth::logout();
        } else {
            Auth::logout();
        }

        return $this->engineReaction(2, null, __tr('User logout failed.'));
    }

    /**
     * Process App logout request.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processAppLogout()
    {
        Auth::logout();

        return $this->engineReaction(1, ['auth_info' => getUserAuthInfo()], 'logout Successfully');
    }

    /**
     * User Sign prepare.
     *-----------------------------------------------------------------------*/
    public function prepareSignupData()
    {
        $allGenders = configItem('user_settings.gender');
        $genders = [];
        foreach ($allGenders as $key => $value) {
            $genders[] = [
                'id' => $key,
                'value' => $value,
            ];
        }

        return $this->engineReaction(1, [
            'genders' => $genders,
        ]);
    }

    /**
     * User Sign Process.
     *
     * @param array $inputData
     *
     *-----------------------------------------------------------------------*/
    public function userSignUpProcess_old($inputData)
    {
        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData) { 
            $activationRequiredForNewUser = getStoreSettings('activation_required_for_new_user');
            $inputData['status'] = 1; // Active
            // check if activation is required for new user
            if ($activationRequiredForNewUser) {
                $inputData['status'] = 4; // Never Activated
            }

            // Store user
            $newUser = $this->userRepository->storeUser($inputData);
            $userId = $newUser->_id;
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }
            $userrole = (int) ($inputData['usertype']);
            $userAuthorityData = [
                'user_id' => $newUser->_id,
                'user_roles__id' => $userrole,
            ];
            // Add user authority
            if ($this->userRepository->storeUserAuthority($userAuthorityData)) {
                // store profile image
                $fileName = '';
                $base64Image = $inputData['profile_image'];
                $uid = $newUser->_uid;
                $uploadedFileOnLocalServer = $this->mediaEngine->processSaveBase64ImageToLocalServer($base64Image, 'profile', $uid, 'profile');
                if ($uploadedFileOnLocalServer['reaction_code'] == 1) {
                    $uploadedFileData = $uploadedFileOnLocalServer['data'];
                    $fileName = $uploadedFileData['fileName'];
                }
                //check enable bonus credits for new user
                if (getStoreSettings('enable_bonus_credits')) {
                    $creditWalletStoreData = [
                        'status' => 1,
                        'users__id' => $newUser->_id,
                        'credits' => getStoreSettings('number_of_credits'),
                        'credit_type' => 1, //Bonuses
                    ];
                    //store user credit transaction data
                    if (!$this->userRepository->storeCreditWalletTransaction($creditWalletStoreData)) {
                        return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User credits not stored.'));
                    }
                }

                $profileData = [
                    'users__id' => $newUser->_id,
                    'status' => 2,
                    'user_roles__id' => $userrole,
                    'profile_picture' => $fileName,
                ];

                if ($userrole == 2) {
                    // partner role
                    $profileData['kanji_name'] = $inputData['kanji_name'];
                    $profileData['kata_name'] = $inputData['kata_name'];
                    $profileData['dob'] = $inputData['dob'];
                    $profileData['gender'] = $inputData['gender'];
                }

                if ($userrole == 3) {
                    // pt
                    $profileData['kanji_name'] = $inputData['kanji_name'];
                    $profileData['kata_name'] = $inputData['kata_name'];
                    $profileData['dob'] = $inputData['dob'];
                    $profileData['do_qualify'] = $inputData['do_qualify'];
                    $profileData['gender'] = $inputData['gender'];
                }

                if ($userrole == 4 || $userrole == 5) {
                    // gym , brand

                    $profileData['company_name'] = $inputData['company_name'];
                    $profileData['brand'] = $inputData['brand'];
                    $profileData['do_start'] = $inputData['do_start'];
                    $profileData['website'] = $inputData['website'];
                }
                //store available time
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
                $user_time['user_id'] = $newUser->_id;
                $this->userRepository->updateUserTime($user_time);  // storeUserTime
                //store profile
                if ($this->userRepository->storeUserProfile($profileData)) {
                    // store city and gym
                    if (getStoreSettings('allow_google_map')) {
                        $this->processStoreLocationData($inputData, $userId);
                        $this->userRepository->deleteUserGymData($userId);
                        // store gym selectoion
                        $gymList = explode(",", $inputData["gym_selected_list"]);
                        // Loop over the gym id list data
                        foreach ($gymList as $gym_id) {
                            $this->userRepository->storeUserGymData($gym_id, $userId);
                        }
                        
                    } else {
                        // if use static gym, city
                        $city = $inputData['selected_city_id'];
                        $this->processStoreCity($city, $userId);
                        //$gym = $inputData['selected_city_id']; // selected_gym_id
                        //$this->processStoreGym($gym, $userId);
                    }

                    //check activation required for new users
                    if ($activationRequiredForNewUser) {
                        if (isMobileAppRequest()) {
                            $emailData = [
                                'fullName' => $newUser->first_name,
                                'email' => $newUser->email,
                                'expirationTime' => configItem('otp_expiry'),
                                'otp' => $newUser->remember_token,
                            ];
                            // check if email send to member
                            if ($this->baseMailer->notifyToUser('Your account registered successfully.', 'account.activation-for-app', $emailData, $newUser->email)) {
                                return $this->userRepository->transactionResponse(1, [
                                    'show_message' => true,
                                    'activation_required' => true,
                                ], __tr('Your account created successfully, to activate your account please check your email.'));
                            }
                        } else {
                            $emailData = [
                                'fullName' => $newUser->first_name,
                                'email' => $newUser->email,
                                'expirationTime' => configItem('account.expiry'),
                                'activation_url' => URL::temporarySignedRoute('user.account.activation', Carbon::now()->addHours(configItem('account.expiry')), ['userUid' => $newUser->_uid]),
                            ];
                            // check if email send to member
                            if ($this->baseMailer->notifyToUser('Your account registered successfully.', 'account.activation', $emailData, $newUser->email)) {
                                return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Your account created successfully, to activate your account please check your email.'));
                            }
                        }
                    } else {
                        return $this->userRepository->transactionResponse(1, ['show_message' => true], __tr('Your account created successfully.'));
                    }
                }
            }
            // Send failed server error message
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    // Signup processing with step wizard

    public function userSignUpProcess($inputData){

        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData) { 
            $activationRequiredForNewUser = getStoreSettings('activation_required_for_new_user');
            $inputData['status'] = 1; // Active
            // check if activation is required for new user
            if ($activationRequiredForNewUser) {
               // $inputData['status'] = 4; // Never Activated
            }

            // Store user
            $newUser = $this->userRepository->storeUser($inputData);
            $userId = $newUser->_id;
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }
            $userrole = (int) ($inputData['usertype']);
            $userAuthorityData = [
                'user_id' => $newUser->_id,
                'user_roles__id' => $userrole,
            ];
            // Add user authority
            if ($this->userRepository->storeUserAuthority($userAuthorityData)) {
                return $this->userRepository->transactionResponse(1, ['show_message' => true, 'user_id'=>$userId], __tr('Your account created successfully.'));
            }
            // Send failed server error message
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function userSignUpProfileProcess($inputData){
        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData) { 
            
            $userId = getUserID();
            $newUser = $this->userRepository->fetch($userId);
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }

            $userrole = $newUser->user_role_id;    
            $fileName = '';
            $base64Image = $inputData['profile_image'];
            $uid = $newUser->_uid;
            $uploadedFileOnLocalServer = $this->mediaEngine->processSaveBase64ImageToLocalServer($base64Image, 'profile', $uid, 'profile');
            if ($uploadedFileOnLocalServer['reaction_code'] == 1) {
                $uploadedFileData = $uploadedFileOnLocalServer['data'];
                $fileName = $uploadedFileData['fileName'];
            }
            
            $profileData = [
                'users__id' => $newUser->_id,
                'status' => 2,
                'user_roles__id' => $userrole,
                'profile_picture' => $fileName,
            ];

            if ($userrole == 2) {
                // partner role
                $profileData['kanji_name'] = $inputData['kanji_name'];
                $profileData['kata_name'] = $inputData['kata_name'];
                $profileData['dob'] = $inputData['dob'];
                $profileData['gender'] = $inputData['gender'];
            }

            if ($userrole == 3) {
                // pt
                $profileData['kanji_name'] = $inputData['kanji_name'];
                $profileData['kata_name'] = $inputData['kata_name'];
                $profileData['dob'] = $inputData['dob'];
                $profileData['do_qualify'] = $inputData['do_qualify'];
                $profileData['gender'] = $inputData['gender'];
            }

            if ($userrole == 4 || $userrole == 5) {
                // gym , brand

                $profileData['company_name'] = $inputData['company_name'];
                $profileData['brand'] = $inputData['brand'];
                $profileData['do_start'] = $inputData['do_start'];
                $profileData['website'] = $inputData['website'];
            }

            $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
            if($userProfile){
                if ($this->userRepository->updateProfile($userProfile, $profileData)) {
                    return $this->userRepository->transactionResponse(1, ['show_message' => true, 'user_id'=>$userId], __tr('Your profile updated successfully.'));
                }
            } else {
                if ($this->userRepository->storeUserProfile($profileData)) {
                    return $this->userRepository->transactionResponse(1, ['show_message' => true, 'user_id'=>$userId], __tr('Your profile created successfully.'));
                }
            }
            
            // Send failed server error message
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function userSignUpAvailabilityProcess($inputData){
        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData) { 
            $inputData['status'] = 3; // Step 3 Availability
            $userId = getUserID();
            $newUser = $this->userRepository->fetch($userId);
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }

            //store available time
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
            $user_time['user_id'] = $newUser->_id;
            if($this->userRepository->updateUserTime($user_time)){
                return $this->userRepository->transactionResponse(1, ['show_message' => true, 'user_id'=>$userId], __tr('Your availability updated successfully.'));
            }
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    public function userSignUpLocationProcess($inputData){
        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData) { 
            $inputData['status'] = 4; // Step 4 Location
            $userId = getUserID();
            $newUser = $this->userRepository->fetch($userId);
            // Check if user not stored successfully
            if (!$newUser) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User not added.'));
            }

            try {
                // store city and gym
                if (getStoreSettings('allow_google_map')) {
                    $this->processStoreLocationData($inputData, $userId);
                    $this->userRepository->deleteUserGymData($userId);
                    // store gym selectoion
                    $gymList = explode(",", $inputData["gym_selected_list"]);
                    // Loop over the gym id list data
                    foreach ($gymList as $gym_id) {
                        $this->userRepository->storeUserGymData($gym_id, $userId);
                    }
                    
                } else {
                    // if use static gym, city
                    $city = $inputData['selected_city_id'];
                    $this->processStoreCity($city, $userId);
                    //$gym = $inputData['selected_city_id']; // selected_gym_id
                    //$this->processStoreGym($gym, $userId);
                }
                return $this->userRepository->transactionResponse(1, ['show_message' => true, 'user_id'=>$userId], __tr('Your location updated successfully.'));
            } catch(Exception $e) {  
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));
            }
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Something went wrong on server, please contact to administrator.'));

        });

        return $this->engineReaction($transactionResponse);
    }

    private function processStoreCity($cityId, $userId)
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

    private function processStoreGym($gymId, $userId)
    {

        $gymData = $this->userSettingRepository->fetchGym($gymId);

        //check is empty then show error message
        if (__isEmpty($gymData)) {
            return $this->engineReaction(18, null, __tr('Selected gym not found'));
        }

        $gymName = $gymData->name;
        // Fetch Country code
        $countryDetails = $this->countryRepository->fetchByCountryCode($gymData->country_code);

        //check is empty then show error message
        if (__isEmpty($countryDetails)) {
            return $this->engineReaction(18, null, __tr('Country not found'));
        }

        $countryId = $countryDetails->_id;

        $userGym = [
            'users__id' => $userId,
            'countries__id' => $countryId,
            'name' => $gymName,
            'latitude' => $gymData->latitude,
            'longitude' => $gymData->longitude,
        ];
        // get user profile
        $this->userRepository->storeUserGym($userGym);

        return true;
    }

    /**
     * Process Store Location Data.
     *
     * @param array $inputData
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreLocationData($inputData, $userId)
    { 
        // Get country from input data
        $placeData = json_decode($inputData['address_address']); 
        // check if place data exists
        if (__isEmpty($placeData)) {
            return $this->engineReaction(2, null, __tr('Invalid data proceed.'));
        }

        $countryCode = $cityName = $countryName = '';
        // Loop over the place data
        foreach ($placeData as $place) {
            if (in_array('country', $place->types) or in_array('continent', $place->types)) {
                $countryCode = $place->short_name;
                $countryName = $place->long_name;
            }
            if (in_array('locality', $place->types)) {
                $cityName = $place->long_name;
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

        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        $userProfileDetails = [
            'countries__id' => $countryId,
            'city' => $cityName,
            'location_latitude' => $inputData['address-latitude'],
            'location_longitude' => $inputData['address-longitude'],
            'formatted_address'       => $inputData['input_location']  
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
     * Process Store Gym Data.
     *
     * @param array $inputData
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreGymData($inputData, $userId)
    {  
        // Get country from input data
        $placeData = json_decode($inputData['gym_address']);
        // check if place data exists
        if (__isEmpty($placeData)) {
            return $this->engineReaction(2, null, __tr('Invalid data proceed.'));
        }

        $countryCode = $cityName = $countryName = '';
        // Loop over the place data
        foreach ($placeData as $place) {
            if (in_array('country', $place->types) or in_array('continent', $place->types)) {
                $countryCode = $place->short_name;
                $countryName = $place->long_name;
            }
            if (in_array('locality', $place->types)) {
                $cityName = $place->long_name;
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

        $user = $this->userSettingRepository->fetchUserDetails($userId);
        // Check if user details exists
        if (\__isEmpty($user)) {
            return $this->engineReaction(18, null, __tr('User does not exists.'));
        }
        $userGym = [
            'users__id' => $userId,
            'countries__id' => $countryId,
            'name' => $cityName,
            'latitude' => $inputData['gym-latitude'],
            'longitude' => $inputData['gym-longitude'],
        ];
        // get user profile
        $this->userRepository->storeUserGym($userGym);

        return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
    }

    /**
     * Process user update password request.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processUpdatePassword($inputData)
    {
        $user = Auth::user();
        // Check if logged in user password matched with entered password
        if (!Hash::check($inputData['current_password'], $user->password)) {
            return $this->engineReaction(3, ['show_message' => true], __tr('Current password is incorrect.'));
        }

        // Check if user password updated
        if ($this->userRepository->updatePassword($user, $inputData['new_password'])) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Password updated successfully'));
        }

        return $this->engineReaction(14, ['show_message' => true], __tr('Password not updated.'));
    }

    /**
     * Send new email activation reminder.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processChangeEmail($inputData)
    {
        $user = Auth::user();
        // Check if user entered correct password or not
        if (!Hash::check($inputData['current_password'], $user->password)) {
            return $this->engineReaction(3, ['show_message' => true], __tr('Please check your password.'));
        }
        //get data
        $activationRequired = getStoreSettings('activation_required_for_change_email');

        //check activation required or not
        if ($activationRequired) {
            $emailData = [
                'full_name' => $user->first_name.' '.$user->last_name,
                'newEmail' => $inputData['new_email'],
                'expirationTime' => configItem('account.change_email_expiry'),
                'activation_url' => URL::temporarySignedRoute('user.new_email.activation', Carbon::now()->addHours(configItem('account.change_email_expiry')), ['userUid' => $user->_uid, 'newEmail' => $inputData['new_email']]),
            ];
            // check if email send to member
            if ($this->baseMailer->notifyToUser('New Email Activation.', 'account.new-email-activation', $emailData, $inputData['new_email'])) {
                return $this->engineReaction(1, ['show_message' => true, 'activationRequired' => true], __tr('New email activation link has been sent to your new email address, please check your email.'));
            }
        } else {
            $updateData = [
                'email' => $inputData['new_email'],
            ];
            // Check for if new email activation store
            if ($this->userRepository->updateUser($user, $updateData)) {
                return $this->engineReaction(1, [
                    'show_message' => true,
                    'activationRequired' => false,
                    'newEmail' => $inputData['new_email'],
                ], __tr('Update email successfully.'));
            }
        }
        //error response
        return $this->engineReaction(2, ['show_message' => true], __tr('Email not updated.'));
    }

    /**
     * Activate new email.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processNewEmailActivation($userUid, $newEmail)
    {
        $user = $this->userRepository->fetch($userUid);
        // Check if user record exist
        if (__isEmpty($user)) {
            return $this->engineReaction(2, null, __tr('User data not exists.'));
        }
        $updateData = [
            'email' => $newEmail,
        ];

        // Check for if new email activation store
        if ($this->userRepository->updateUser($user, $updateData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Update email successfully.'));
        }
        //error response
        return $this->engineReaction(2, ['show_message' => true], __tr('Email not updated.'));
    }

    /**
     * Process forgot password request based on passed email address &
     * send password reminder on enter email address.
     *
     * @param string $email
     *
     * @return array
     *---------------------------------------------------------------- */
    public function sendPasswordReminder($email)
    {
        $user = $this->userRepository->fetchActiveUserByEmail($email);

        // Check if user record exist
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('Invalid Request.'));
        }

        // Delete old password reminder for this user
        $this->userRepository->deleteOldPasswordReminder($email);

        $token = YesSecurity::generateUid();
        $createdAt = getCurrentDateTime();

        $storeData = [
            'email' => $email,
            'token' => $token,
            'created_at' => $createdAt,
        ];

        // Check for if password reminder added
        if (!$this->userRepository->storePasswordReminder($storeData)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('Invalid Request.'));
        }

        //message data
        $emailData = [
            'full_name' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
            'expirationTime' => config('__tech.account.password_reminder_expiry'),
            'email' => $user->email,
            'email' => $user->email,
            'email' => $user->email,
            'tokenUrl' => route('user.reset_password', ['reminderToken' => $token]),
        ];

        // if reminder mail has been sent
        if ($this->baseMailer->notifyToUser('Forgot Password.', 'account.password-reminder', $emailData, $user->email)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('We have e-mailed your password reset link.')); // success reaction
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong on server')); // error reaction
    }

    /**
     * Process reset password request.
     *
     * @param array  $input
     * @param string $reminderToken
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processResetPassword($input, $reminderToken)
    {
        $email = $input['email'];

        //check if mobile app request then change request Url
        $token = $reminderToken;

        //get password reminder count
        $count = $this->userRepository->fetchPasswordReminderCount($token, $email);

        // Check if reminder count not exist on 0
        if (!$count > 0) {
            return  $this->engineReaction(18, ['show_message' => true], __tr('Invalid Request.'));
        }

        //fetch active user by email
        $user = $this->userRepository->fetchActiveUserByEmail($email);

        // Check if user record exist
        if (__isEmpty($user)) {
            return  $this->engineReaction(18, ['show_message' => true], __tr('Invalid Request.'));
        }

        // Check if user password updated
        if ($this->userRepository->resetPassword($user, $input['password'])) {
            return  $this->engineReaction(1, ['show_message' => true], __tr('Password reset successfully.'));
        }

        //failed response
        return  $this->engineReaction(2, ['show_message' => true], __tr('Password not updated.'));
    }

    /**
     * Process Account Activation.
     *
     * @param string $userUid
     *
     *-----------------------------------------------------------------------*/
    public function processAccountActivation($userUid)
    {
        $neverActivatedUser = $this->userRepository->fetchNeverActivatedUser($userUid);

        // Check if never activated user exist or not
        if (__isEmpty($neverActivatedUser)) {
            return $this->engineReaction(18, null, __tr('Account Activation link invalid.'));
        }

        $updateData = [
            'status' => 1, // Active
        ];
        // Check if user activated successfully
        if ($this->userRepository->updateUser($neverActivatedUser, $updateData)) {
            return $this->engineReaction(1, null, __tr('Your account has been activated successfully. Login with your email ID and password.'));
        }

        return  $this->engineReaction(2, null, __tr('Account Activation link invalid.'));
    }

    /**
     * Prepare User Profile Data.
     *
     * @param string $userName
     *
     *-----------------------------------------------------------------------*/
    public function prepareUserProfile($userName)
    {
        
        // fetch User by username
        $user = $this->userRepository->fetchByUsername($userName, true);
        
        if($userName == ""){
            $user = $this->userSettingRepository->fetchUserDetails(getUserID());
        }

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, [], __tr('User does not exists.'));
        }
        $userId = $user->_id;
        $userUid = $user->_uid;
        $isOwnProfile = ($userId == getUserID()) ? true : false;
        // Prepare user data
        $userData = [
            'userId' => $userId,
            'userUId' => $userUid,
            'fullName' => $user->kanji_name.' '.$user->kata_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'kanji_name' => $user->kanji_name,
            'mobile_number' => $user->mobile_number,
            'userName' => $user->username,
            'userRoleId'  =>  $user->userRoleId
        ];

        $usertime = $this->userRepository->getUserAvailability($userId);
        $userProfileData = $userSpecifications = $userSpecificationData = $photosData = $userReviews = [];

        // fetch User details
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
        $userSettingConfig = configItem('user_settings');
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $userUid]);
        $profilePictureUrl = noThumbImageURL();
        $coverPictureFolderPath = getPathByKey('cover_photo', ['{_uid}' => $userUid]);
        $coverPictureUrl = noThumbCoverImageURL();
        // Check if user profile exists
        if (!__isEmpty($userProfile)) {
            if (!__isEmpty($userProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userProfile->profile_picture);
            }
            if (!__isEmpty($userProfile->cover_picture)) {
                $coverPictureUrl = getMediaUrl($coverPictureFolderPath, $userProfile->cover_picture);
            }
        }
        // Set cover and profile picture url
        $userData['profilePicture'] = $profilePictureUrl;
        $userData['coverPicture'] = $coverPictureUrl;
        $userData['userAge'] = isset($userProfile->dob) ? Carbon::parse($userProfile->dob)->age : null;

        // check if user profile exists
        if (!\__isEmpty($userProfile)) {
            // Get country name
            $countryName = '';
            if (!__isEmpty($userProfile->countries__id)) {
                $country = $this->countryRepository->fetchById($userProfile->countries__id, ['name']);
                $countryName = $country->name;
            }

            //fetch user liked data by to user id
            $peopleILikeUserIds = $this->userRepository->fetchMyLikeDataByUserId($user->_id)->pluck('to_users__id')->toArray();

            $showMobileNumber = true;
            //check login user exist then don't apply this condition.
            if ($user->_id != getUserID()) {
                //check admin can set true mobile number not display of user
                if (getStoreSettings('display_mobile_number') == 1) {
                    $showMobileNumber = false;
                }
                //check admin can set user choice user can show or not mobile number
                if (getStoreSettings('display_mobile_number') == 2 and getUserSettings('display_user_mobile_number', $user->_id) == 1) {
                    $showMobileNumber = false;
                }
                //check admin can set user choice and user can select people I liked user
                if (getStoreSettings('display_mobile_number') == 2 and getUserSettings('display_user_mobile_number', $user->_id) == 2 and !in_array(getUserID(), $peopleILikeUserIds)) {
                    $showMobileNumber = false;
                }
            }

            $userProfileData = [
                'aboutMe' => $userProfile->about_me,
                'city' => $userProfile->city,
                'mobile_number' => $user->mobile_number,
                'showMobileNumber' => $showMobileNumber,
                'gender' => $userProfile->gender,
                'gender_text' => array_get($userSettingConfig, 'gender.'.$userProfile->gender),
                'country' => $userProfile->countries__id,
                'country_name' => $countryName,
                'dob' => $userProfile->dob,
                'birthday' => (!\__isEmpty($userProfile->dob))
                    ? formatDate($userProfile->dob)
                    : '',
                'qualified_date' => (!\__isEmpty($userProfile->do_qualify))
                ? formatDate($userProfile->do_qualify, 'Y/m/d')                // jS F Y
                : '',    // 
                'do_qualify' => $userProfile->do_qualify,
                'website' => $userProfile->website,
                'work_status' => $userProfile->work_status,
                'formatted_work_status' => array_get($userSettingConfig, 'work_status.'.$userProfile->work_status),
                'education' => $userProfile->education,
                'formatted_education' => array_get($userSettingConfig, 'educations.'.$userProfile->education),
                'preferred_language' => $userProfile->preferred_language,
                'formatted_preferred_language' => array_get($userSettingConfig, 'preferred_language.'.$userProfile->preferred_language),
                'relationship_status' => $userProfile->relationship_status,
                'formatted_relationship_status' => array_get($userSettingConfig, 'relationship_status.'.$userProfile->relationship_status),
                'latitude' => $userProfile->location_latitude,
                'longitude' => $userProfile->location_longitude,
                'isVerified' => $userProfile->is_verified,
                'formatted_address' => $userProfile->formatted_address,
            ];
        }

        $specificationCollection = $this->userSettingRepository->fetchUserSpecificationById($userId);
        // Check if user specifications exists
        if (!\__isEmpty($specificationCollection)) {
            $userSpecifications = $specificationCollection->pluck('specification_value', 'specification_key')->toArray();
        }
        $specificationConfig = $this->getUserSpecificationConfig();
        foreach ($specificationConfig['groups'] as $specKey => $specification) {
            $items = [];
            foreach ($specification['items'] as $itemKey => $item) {
                if (!$isOwnProfile and array_key_exists($itemKey, $userSpecifications)) {
                    $userSpecKey = $userSpecifications[$itemKey];
                    $items[] = [
                        'name' => $itemKey,
                        'label' => $item['name'],
                        'input_type' => $item['input_type'],
                        'value' => (isset($item['options']) and isset($item['options'][$userSpecKey]))
                            ? $item['options'][$userSpecKey]
                            : $userSpecifications[$itemKey],
                        'options' => isset($item['options']) ? $item['options'] : '',
                        'selected_options' => (!__isEmpty($userSpecKey)) ? $userSpecKey : '',
                    ];
                } elseif ($isOwnProfile) {
                    $itemValue = '';
                    $userSpecValue = isset($userSpecifications[$itemKey])
                        ? $userSpecifications[$itemKey]
                        : '';
                    if (!__isEmpty($userSpecValue)) {
                        $itemValue = isset($item['options'])
                            ? (isset($item['options'][$userSpecValue])
                                ? $item['options'][$userSpecValue] : '')
                            : $userSpecValue;
                    }
                    $items[] = [
                        'name' => $itemKey,
                        'label' => $item['name'],
                        'input_type' => $item['input_type'],
                        'value' => $itemValue,
                        'options' => isset($item['options']) ? $item['options'] : '',
                        'selected_options' => $userSpecValue,
                    ];
                }
            }
            // Check if Item exists
            if (!__isEmpty($items)) {
                $userSpecificationData[$specKey] = [
                    'title' => $specification['title'],
                    'icon' => $specification['icon'],
                    'items' => $items,
                ];
            }
        }

        // // Get user photos collection
        // $userPhotosCollection = $this->userSettingRepository->fetchUserPhotos($userId);
        // $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userUid]);
        // // check if user photos exists
        // if (!__isEmpty($userPhotosCollection)) {
        //     foreach ($userPhotosCollection as $userPhoto) {
        //         $photosData[] = [
        //             'photoUId'   => $userPhoto->_uid,
        //             'photo_user_id'   => $userId,
        //             'user_comment'   => $userPhoto->comment,
        //             'created_at'   => formatDiffForHumans($userPhoto->created_at),
        //             'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->file),
        //             //'is_like'   => $userPhoto->is_like,
        //             //'is_tagged'   => $userPhoto->is_tagged,
        //             'removePhotoUrl' => route('user.upload_photos.write.delete', ['photoUid' => $userPhoto->_uid]),
        //         ];
        //     }
        // }

        //fetch like dislike data by to user id
        $likeDislikeData = $this->userRepository->fetchLikeDislike($user->_id);
        $mutualLike = $this->userRepository->checkMutualFollow($user->_id);
        $userLikeData = [];
        //check is not empty
        if (!__isEmpty($likeDislikeData)) {
            $userLikeData = [
                '_id' => $likeDislikeData->_id,
                'like' => $likeDislikeData->like,
                'mutual' => $mutualLike,
            ];
        }

        //check loggedIn User id doesn't match current user id then
        // store visitor profile data
        if ($userId != getUserID()) {

            // Checking possiblity from membership
            // getting current membership, user_role , corresponding configuration of premium features
            //  PT, Partner

            $featurePlanSettings = getStoreSettings('feature_plans');
            // Fetch default setting
            $defaultSettings = config('__settings.items.premium-feature');
            $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
            //collect feature plan json data into array
            $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
            $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);

            $userMembership = getUserMembership();  //  pro ; standard  , premium
            $userInfo = getUserAuthInfo();
            $user_role_name = strtolower( $userInfo['profile']['role'] );
            
            $incognito_mode_setting = $featurePlanCollection['partner']['browse_incognito_mode']['select_user'];    
            $status = 1;
            if( $user_role_name=="partner" ) {
                if( $incognito_mode_setting == 1){
                    $status =2;
                } else {
                    if( $incognito_mode_setting == 2 ) {
                        if( $userMembership == "pro"){
                            $status =2;
                        }
                    }
                }
            }

            $profileVisitorData = $this->userRepository->fetProfileVisitorByUserId($userId);
            //check is empty then store profile visitor data
            if (__isEmpty($profileVisitorData)) {
                $storeData = [
                    'status' => $status, // 1 normal , 2: not showing as incognito mode
                    'to_users__id' => $userId,
                    'by_users__id' => getUserID(),
                ];

                //store profile visitors data
                if ($this->userRepository->storeProfileVisitors($storeData)) {

                    //user full name
                    $userFullName = $user->first_name.' '.$user->last_name;

                    //loggedIn user name
                    $loggedInUserName = Auth::user()->first_name.' '.Auth::user()->last_name;

                    if( $userFullName == " "){
                        $userFullName = $user->username;
                    }
                    if( $loggedInUserName == " "){
                        $userInfo = getUserAuthInfo();
                        $loggedInUserName = array_get($userInfo, 'profile.full_name');
                    }

                    
                    //activity log message
                    activityLog($userFullName.' '.'profile visited.');

                    //check user browser
                    $allowVisitorProfile = getFeatureSettings('browse_incognito_mode');
                    //check in setting allow visitor notification log and pusher request
                    if (!$allowVisitorProfile) {
                        //notification log message
                        notificationLog('Profile visited by'.' '.$loggedInUserName, route('user.profile_view', ['username' => Auth::user()->username]), null, $userId, getUserID(), 'profile-visitor');
                        //push data to pusher
                        PushBroadcast::notifyViaPusher('event.user.notification', [
                            'type' => 'profile-visitor',
                            'userUid' => $userUid,
                            'subject' => __tr('Profile visited successfully'),
                            'message' => __tr('Profile visited by').' '.$loggedInUserName,
                            'messageType' => __tr('success'),
                            'showNotification' => getUserSettings('show_visitor_notification', $user->_id),
                            'getNotificationList' => getNotificationList($user->_id),
                        ]);
                    }
                } else {
                    return $this->engineReaction(18, [], __tr('Profile visitors not created.'));
                }
            }
        }

        
        // $likePhotosdata = [];
        // // Get user photos collection
        // $userLikeFeedPhotosCollection = $this->userSettingRepository->fetchUserLikeFeedPhotos($userId);
        
        // // check if user photos exists
        // if (!__isEmpty($userLikeFeedPhotosCollection)) {
        //     foreach ($userLikeFeedPhotosCollection as $userPhoto) {
        //         $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
        //         $likePhotosdata[] = [
        //             'photoUId'   => $userPhoto->photo_uid,
        //             'photo_user_id'   => $userPhoto->photo_user_id,
        //             'user_comment'   => $userPhoto->comment,
        //             'created_at'   => formatDiffForHumans($userPhoto->created_at),
        //             'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
        //             'is_like'   => $userPhoto->is_like,
        //             'is_tagged' => $userPhoto->is_tagged
        //         ];
        //     }
        // }

        // $taggedPhotosdata = [];
        // // Get user photos collection
        // $userTaggedFeedPhotosCollection = $this->userSettingRepository->fetchUserTaggedFeedPhotos($userId);
        
        // // check if user photos exists
        // if (!__isEmpty($userTaggedFeedPhotosCollection)) {
        //     foreach ($userTaggedFeedPhotosCollection as $userPhoto) {
        //         $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
        //         $taggedPhotosdata[] = [
        //             'user_comment'   => $userPhoto->comment,
        //             'photo_user_id'   => $userPhoto->photo_user_id,
        //             'created_at'   => formatDiffForHumans($userPhoto->created_at),
        //             'photoUId'   => $userPhoto->photo_uid,
        //             'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
        //         ];
        //     }
        // }


        //fetch total visitors data
        $visitorData = $this->userRepository->fetchProfileVisitor($userId);

        //fetch gift collection
        $giftCollection = $this->manageItemRepository->fetchListData(1);

        $giftListData = [];
        if (!__isEmpty($giftCollection)) {
            foreach ($giftCollection as $key => $giftData) {
                //only active gifts
                if ($giftData->status == 1) {
                    $giftImageUrl = '';
                    $giftImageFolderPath = getPathByKey('gift_image', ['{_uid}' => $giftData->_uid]);
                    $giftImageUrl = getMediaUrl($giftImageFolderPath, $giftData->file_name);
                    //get normal price or normal price is zero then show free gift
                    $normalPrice = (isset($giftData['normal_price']) and intval($giftData['normal_price']) <= 0) ? 'Free' : intval($giftData['normal_price']).' '.__tr('credits');

                    //get premium price or premium price is zero then show free gift
                    $premiumPrice = (isset($giftData['premium_price']) and $giftData['premium_price'] <= 0) ? 'Free' : $giftData['premium_price'].' '.__tr('credits');
                    $giftData['premium_price'].' '.__tr('credits');

                    $price = 'Free';
                    //check user is premium or normal or Set price
                    if (isPremiumUser()) {
                        $price = $premiumPrice;
                    } else {
                        $price = $normalPrice;
                    }
                    $giftListData[] = [
                        '_id' => $giftData['_id'],
                        '_uid' => $giftData['_uid'],
                        'normal_price' => $normalPrice,
                        'premium_price' => $giftData['premium_price'],
                        'formattedPrice' => $price,
                        'gift_image_url' => $giftImageUrl,
                    ];
                }
            }
        }

        //fetch user gift record
        $userGiftCollection = $this->userRepository->fetchUserGift($userId);

        $userGiftData = [];
        //check if not empty
        if (!__isEmpty($userGiftCollection)) {
            foreach ($userGiftCollection as $key => $userGift) {
                $userGiftImgUrl = '';
                $userGiftFolderPath = getPathByKey('gift_image', ['{_uid}' => $userGift->itemUId]);
                $userGiftImgUrl = getMediaUrl($userGiftFolderPath, $userGift->file_name);
                //check gift status is private (1) and check gift send to current user or gift send by current user
                if ($userGift->status == 1 and ($userGift->to_users__id == getUserID() || $userGift->from_users__id == getUserID())) {
                    $userGiftData[] = [
                        '_id' => $userGift->_id,
                        '_uid' => $userGift->_uid,
                        'itemId' => $userGift->itemId,
                        'status' => $userGift->status,
                        'fromUserName' => $userGift->fromUserName,
                        'senderUserName' => $userGift->senderUserName,
                        'userGiftImgUrl' => $userGiftImgUrl,
                    ];
                //check gift status is public (0)
                } elseif ($userGift->status != 1) {
                    $userGiftData[] = [
                        '_id' => $userGift->_id,
                        '_uid' => $userGift->_uid,
                        'itemId' => $userGift->itemId,
                        'status' => $userGift->status,
                        'fromUserName' => $userGift->fromUserName,
                        'senderUserName' => $userGift->senderUserName,
                        'userGiftImgUrl' => $userGiftImgUrl,
                    ];
                }
            }
        }

        //fetch block me users
        $blockMeUser = $this->userRepository->fetchBlockMeUser($user->_id);
        $isBlockUser = false;
        //check if not empty then set variable is true
        if (!__isEmpty($blockMeUser)) {
            $isBlockUser = true;
        }

        //fetch block by me user
        $blockUserData = $this->userRepository->fetchBlockUser($user->_id);
        $blockByMe = false;
        //if it is empty
        if (!__isEmpty($blockUserData)) {
            $blockByMe = true;
        }

        //fetch reviewed user data
        $reviewUserData = $this->manageReviewRepository->fetchReviewByUser( [$user->_id]);
        $reviewMeUser = $this->manageReviewRepository->fetchReviewByMeUser($user->_id);
        $isReviewedUser = false;
        //check if not empty then set variable is true
        if (!__isEmpty($reviewMeUser)) {
            $isReviewedUser = true;
        }
        $totalReviewRate = $this->manageReviewRepository->fetchTotalRateUser( $user->_id);

        // Gym setting data
        $userGymsCollection = $this->userRepository->fetchUserGymData($user->_id);
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
        $userExpertiseCollection = $this->userRepository->fetchUserExpertiseData($user->_id);
        $expertiseListCollection = $this->userRepository->fetchExpertiseListData();
        // Pt user pricing items
        $userPricingCollection = $this->userRepository->fetchUserSessionData($user->_id);

        return $this->engineReaction(1, [
            'isOwnProfile' => $isOwnProfile,
            'userData' => $userData,
            'countries' => $this->countryRepository->fetchAll()->toArray(),
            'genders' => $userSettingConfig['gender'],
            'preferredLanguages' => $userSettingConfig['preferred_language'],
            'relationshipStatuses' => $userSettingConfig['relationship_status'],
            'workStatuses' => $userSettingConfig['work_status'],
            'educations' => $userSettingConfig['educations'],
            'userProfileData' => $userProfileData,
            //'photosData' => $photosData,
            'userSpecificationData' => $userSpecificationData,
            'userLikeData' => $userLikeData,
            'totalUserLike' => fetchTotalUserLikedCount($userId),
            'totalUserMakeLike' => fetchTotalUserMakeLikeCount($userId),
            'totalVisitors' => $visitorData->count(),
            'isBlockUser' => $isBlockUser,
            'blockByMeUser' => $blockByMe,
            'giftListData' => $giftListData,
            'userGiftData' => $userGiftData,
            'userOnlineStatus' => $this->getUserOnlineStatus($user->userAuthorityUpdatedAt),
            'isPremiumUser' => isPremiumUser($userId),
            'userAvailability' => $usertime,
            'reviewUserData'       => $reviewUserData,
            'isReviewedUser'       => $isReviewedUser,
            'totalReviewRate'    => $totalReviewRate,
            'userGymsData'         => $userGymsData,
            'userExpertiseData'    => $userExpertiseCollection->toArray(),
            'expertiseListData'    => $expertiseListCollection->toArray(),
            'userPricingData'      => $userPricingCollection->toArray(),
            //'likePhotosData' => $likePhotosdata ,
            //'taggedPhotosdata'  => $taggedPhotosdata 
        ]);
    }

    public function prepareUserPhotoData($userName) {

        // fetch User by username
        $user = $this->userRepository->fetchByUsername($userName, true);
        
        if($userName == ""){
            $user = $this->userSettingRepository->fetchUserDetails(getUserID());
        }

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, [], __tr('User does not exists.'));
        }
        $userId = $user->_id;
        $userUid = $user->_uid;
        $isOwnProfile = ($userId == getUserID()) ? true : false;
        $photosData = [];
        // Get user photos collection
        $userPhotosCollection = $this->userSettingRepository->fetchUserPhotos($userId);
        $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userUid]);
        // check if user photos exists
        if (!__isEmpty($userPhotosCollection)) {
            foreach ($userPhotosCollection as $userPhoto) {
                $photosData[] = [
                    'photoUId'   => $userPhoto->_uid,
                    'photo_user_id'   => $userId,
                    'user_comment'   => $userPhoto->comment,
                    'created_at'   => formatDiffForHumans($userPhoto->created_at),
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->file),
                    //'is_like'   => $userPhoto->is_like,
                    //'is_tagged'   => $userPhoto->is_tagged,
                    'removePhotoUrl' => route('user.upload_photos.write.delete', ['photoUid' => $userPhoto->_uid]),
                ];
            }
        }

        return $this->engineReaction(1, [
            'photosData' => $photosData,
            'isOwnProfile' => $isOwnProfile
        ]);
    }
    
    public function prepareUserPhotoTaggedData($userName) {
        
        // fetch User by username
        $user = $this->userRepository->fetchByUsername($userName, true);
        
        if($userName == ""){
            $user = $this->userSettingRepository->fetchUserDetails(getUserID());
        }

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, [], __tr('User does not exists.'));
        }
        $userId = $user->_id;
        $userUid = $user->_uid;

        $taggedPhotosdata = [];
        // Get user photos collection
        $userTaggedFeedPhotosCollection = $this->userSettingRepository->fetchUserTaggedFeedPhotos($userId);
        
        // check if user photos exists
        if (!__isEmpty($userTaggedFeedPhotosCollection)) {
            foreach ($userTaggedFeedPhotosCollection as $userPhoto) {
                $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
                $taggedPhotosdata[] = [
                    'user_comment'   => $userPhoto->comment,
                    'photo_user_id'   => $userPhoto->photo_user_id,
                    'created_at'   => formatDiffForHumans($userPhoto->created_at),
                    'photoUId'   => $userPhoto->photo_uid,
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
                ];
            }
        }

        return $this->engineReaction(1, [
            'taggedPhotosdata' => $taggedPhotosdata,
        ]);
    }

    public function prepareUserPhotoFavouriteData($userName) {

        // fetch User by username
        $user = $this->userRepository->fetchByUsername($userName, true);
        
        // temp , to make for only loginned user

        $userName = "";
        if($userName == ""){
            $user = $this->userSettingRepository->fetchUserDetails(getUserID());
        }

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, [], __tr('User does not exists.'));
        }
        $userId = $user->_id;
        $userUid = $user->_uid;

        $likePhotosdata = [];
        // Get user photos collection
        $userLikeFeedPhotosCollection = $this->userSettingRepository->fetchUserLikeFeedPhotos($userId);
        
        // check if user photos exists
        if (!__isEmpty($userLikeFeedPhotosCollection)) {
            foreach ($userLikeFeedPhotosCollection as $userPhoto) {
                $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
                $likePhotosdata[] = [
                    'photoUId'   => $userPhoto->photo_uid,
                    'photo_user_id'   => $userPhoto->photo_user_id,
                    'user_comment'   => $userPhoto->comment,
                    'created_at'   => formatDiffForHumans($userPhoto->created_at),
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
                    'is_like'   => $userPhoto->is_like,
                    'is_tagged' => $userPhoto->is_tagged
                ];
            }
        }
        return $this->engineReaction(1, [
            'likePhotosData' => $likePhotosdata ,
        ]);
    }

    /**
     * User Like Dislike Process.
     *
     *-----------------------------------------------------------------------*/
    public function processUserLikeDislike($toUserUid, $like)
    {
        // fetch User by toUserUid
        $user = $this->userRepository->fetch($toUserUid);

        $show_message = false;
        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => $show_message], __tr('User does not exists.'));
        }

        //delete old encounter User
        $this->userEncounterRepository->deleteOldEncounterUser();

        //user full name
        $userFullName = $user->first_name.' '.$user->last_name;
        //loggedIn user name
        $loggedInUserFullName = Auth::user()->first_name.' '.Auth::user()->last_name;

        $userInfo = getUserAuthInfo();

        if( $userFullName == " "){
            $userFullName = $user->username;
        }
        if( $loggedInUserFullName == " "){
            $loggedInUserFullName = array_get($userInfo, 'profile.kanji_name');
        }

        $loggedInUserName = Auth::user()->username;

        $showLikeNotification = getFeatureSettings('show_like', null, $user->_id);
        $showLikeNotification = true;

        // Checking possiblity from membership
        // getting current membership, user_role , corresponding configuration of premium features
        //  PT, Partner

        $featurePlanSettings = getStoreSettings('feature_plans');
        // Fetch default setting
        $defaultSettings = config('__settings.items.premium-feature');
        $defaultFeaturePlans = $defaultSettings['feature_plans']['default'];
        //collect feature plan json data into array
        $featureSettings = is_array($featurePlanSettings) ? $featurePlanSettings : json_decode($featurePlanSettings, true);
        $featurePlanCollection = combineArray($defaultFeaturePlans, $featureSettings);

        $userMembership = getUserMembership();  //  pro ; standard  , premium
        $user_role = strtolower( $userInfo['profile']['role']);
        $isAllowOnlyPro = $user_role != 'admin' && ( $featurePlanCollection[$user_role]['unlimited_follows_everyday']['select_user'] == 2);
        $isAllowedLike = true;
        if( $isAllowOnlyPro && ($userMembership != "pro" && $userMembership != "premium")) {
            $numberLimitFollowDay = 3; // 
            if( $this->userRepository->fetchCountFollowToday(getUserID()) >=  $numberLimitFollowDay ) {
                $isAllowedLike = false;
            }
        }

        //fetch like dislike data by to user id
        $likeDislikeData = $this->userRepository->fetchLikeDislike($user->_id);





        //check if not empty
        if (!__isEmpty($likeDislikeData)) {
            //if user already liked then show error messages
            if ($like == $likeDislikeData['like'] and $like == 1) {

                if ($this->userRepository->deleteLikeDislike($likeDislikeData)) {
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 1,
                        'mutual' => $mutualLike,
                        'status' => 'deleted',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('Following Removed Successfully'));
                }
            } elseif ($like == $likeDislikeData['like'] and $like == 0) {
                if ($this->userRepository->deleteLikeDislike($likeDislikeData)) {
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 2,
                        'mutual' => $mutualLike,
                        'status' => 'deleted',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('User Disliked Removed Successfully'));
                }
            }

            //update data
            $updateData = ['like' => $like, 'status' => 1];

            if($like == 1 && !$isAllowedLike) {
                return $this->engineReaction(1, ['show_message' => $show_message], __tr('You are limited follows today.'));
            }

            //update like dislike
            if ($this->userRepository->updateLikeDislike($likeDislikeData, $updateData)) {
                //is like 1
                if ($like == 1) {

                    //activity log message
                    activityLog($userFullName.' '.'profile liked.');
                    //check show like feature return true
                    if ($showLikeNotification) {
                        //notification log message
                        notificationLog('Profile Followed by'.' '.$loggedInUserFullName, route('user.profile_view', ['username' => $loggedInUserName]), null, $user->_id, getUserID(), 'user-likes');
                        //push data to pusher
                        PushBroadcast::notifyViaPusher('event.user.notification', [
                            'type' => 'user-likes',
                            'userUid' => $user->_uid,
                            'subject' => __tr('Followed User successfully'),
                            'message' => __tr('Profile Followed by').' '.$loggedInUserFullName,
                            'messageType' => 'success',
                            'toUserUid' => $toUserUid,
                            'showNotification' => getUserSettings('show_like_notification', $user->_id),
                            'getNotificationList' => getNotificationList($user->_id),
                        ]);
                    }
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 1,
                        'mutual' => $mutualLike,
                        'status' => 'updated',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('Followed User successfully.'));
                } else {
                    //activity log message
                    activityLog($userFullName.' '.'profile Disliked.');
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 2,
                        'mutual' => $mutualLike,
                        'status' => 'updated',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('User Disliked successfully.'));
                }
            }
        } else {
            
            //store data
            $storeData = [
                'status' => 1,
                'to_users__id' => $user->_id,
                'by_users__id' => getUserID(),
                'like' => $like,
            ];
            //store like dislike
            
            if(!$isAllowedLike && $like == 1) {
                return $this->engineReaction(1, ['show_message' => true], __tr('You are limited follows today.'));
            }

            if ($this->userRepository->storeLikeDislike($storeData)) {
                //is like 1
                if ($like == 1) {

                    //activity log message
                    activityLog($userFullName.' '.'profile liked.');
                    //check show like feature return true
                    if ($showLikeNotification) {
                        //notification log message
                        notificationLog('Profile Followed by'.' '.$loggedInUserFullName, route('user.profile_view', ['username' => $loggedInUserName]), null, $user->_id, getUserID(), 'user-likes');

                        //push data to pusher
                        PushBroadcast::notifyViaPusher('event.user.notification', [
                            'type' => 'user-likes',
                            'userUid' => $user->_uid,
                            'subject' => __tr('Followed User successfully'),
                            'message' => __tr('Profile Followed by').' '.$loggedInUserFullName,
                            'messageType' => 'success',
                            'showNotification' => getUserSettings('show_like_notification', $user->_id),
                            'getNotificationList' => getNotificationList($user->_id),
                        ]);
                    }
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 1,
                        'mutual' => $mutualLike,
                        'status' => 'created',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('Following User successfully.'));
                } else {
                    //activity log message
                    activityLog($userFullName.' '.'profile Disliked.');
                    $mutualLike = $this->userRepository->checkMutualFollow($user->_id);

                    return $this->engineReaction(1, [
                        'show_message' => $show_message,
                        'likeStatus' => 2,
                        'mutual' => $mutualLike,
                        'status' => 'created',
                        'toUserUid' => $toUserUid,
                        'totalLikes' => fetchTotalUserLikedCount($user->_id),
                    ], __tr('User Disliked successfully.'));
                }
            }
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong.'));
    }

    public function processUserRemoveLikeDislike( $toUserUid ) {
        // fetch User by toUserUid
        $user = $this->userRepository->fetch($toUserUid);

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User does not exists.'));
        }

        //fetch like dislike data by to user id
        $likeDislikeData = $this->userRepository->fetchLikeDislikeToMe($user->_id);
        //check if not empty
        if (!__isEmpty($likeDislikeData)) {

                if ($this->userRepository->deleteLikeDislike($likeDislikeData)) {
                    return $this->engineReaction(1, [
                        'show_message' => true,
                        'status' => 'deleted',
                        'toUserUid' => $toUserUid,
                    ], __tr('Following Removed Successfully'));
                }
        }  
        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong.'));
    }

    public function processUserHideLiked($toUserUid)
    {
        // fetch User by toUserUid
        $user = $this->userRepository->fetch($toUserUid);

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User does not exists.'));
        }

        //user full name
        $userFullName = $user->first_name.' '.$user->last_name;
        //loggedIn user name
        $loggedInUserFullName = Auth::user()->first_name.' '.Auth::user()->last_name;

        if( $userFullName == " "){
            $userFullName = $user->username;
        }
        if( $loggedInUserFullName == " "){
            $userInfo = getUserAuthInfo();
            $loggedInUserFullName = array_get($userInfo, 'profile.kanji_name');
        }

        $loggedInUserName = Auth::user()->username;

        //fetch like dislike data by to user id
        $likeDislikeData = $this->userRepository->fetchLikeDislikeToMe($user->_id);
        //check if not empty
        if (!__isEmpty($likeDislikeData)) {
            
            //update data
            $updateData = [ 'status' => 2]; // status:2 -> ignored Liked on pending page
            //update like dislike
            if ($this->userRepository->updateLikeDislike($likeDislikeData, $updateData)) {
                
                    //activity log message
                    activityLog($userFullName.' '.'pending hide.');

                    return $this->engineReaction(1, [
                        'show_message' => true,
                        'toUserUid' => $toUserUid,
                    ], __tr('User hided the following user successfully.'));
                
            }
        } else {

            $likeDislikeData = $this->userRepository->fetchLikeDislike($user->_id);
            if (!__isEmpty($likeDislikeData)) {
            
                //update data
                $updateData = [ 'status' => 2]; // status:2 -> ignored Liked on pending page
                //update like dislike
                if ($this->userRepository->updateLikeDislike($likeDislikeData, $updateData)) {
                    
                        //activity log message
                        activityLog($userFullName.' '.'pending hide.');
    
                        return $this->engineReaction(1, [
                            'show_message' => true,
                            'toUserUid' => $toUserUid,
                        ], __tr('User hided the following user successfully.'));
                    
                }
            } else {
                return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong.'));
            }
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Something went wrong.'));
    }  

    /**
     * Prepare User Liked Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareUserLikeDislikedData($likeType)
    {
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData($likeType, true);

        return $this->engineReaction(1, [
            'usersData' => $this->prepareUserArray($likedCollection),
            'nextPageUrl' => $likedCollection->nextPageUrl(),
        ]);
    }

    /**
     * Prepare User Liked Me Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareUserLikeMeData()
    {
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(true);

        return $this->engineReaction(1, [
            'usersData' => $this->prepareUserArray($userLikedMeData),
            'nextPageUrl' => $userLikedMeData->nextPageUrl(),
            'showWhoLikeMeUser' => getFeatureSettings('show_like'),
        ]);
    }

    /**
     * Prepare Mutual like data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareMutualLikeData()
    {
        //fetch user liked data by to user id
        $likedCollection = $this->userRepository->fetchUserLikeData(1, false);
        //pluck people like ids
        $peopleLikeUserIds = $likedCollection->pluck('to_users__id')->toArray();
        //get people likes me data
        $userLikedMeData = $this->userRepository->fetchUserLikeMeData(false)->whereIn('by_users__id', $peopleLikeUserIds);
        //pluck people like me ids
        $mutualLikeIds = $userLikedMeData->pluck('_id')->toArray();
        //get mutual like data
        $mutualLikeCollection = $this->userRepository->fetchMutualLikeUserData($mutualLikeIds);

        return $this->engineReaction(1, [
            'usersData' => $this->prepareUserArray($mutualLikeCollection),
            'nextPageUrl' => $mutualLikeCollection->nextPageUrl(),
        ]);
    }

    public function prepareFollowUserList() {
        $userDetails = getUserAuthInfo();
        $userId = array_get($userDetails, 'profile._id');
        
        $follwing_ids = $this->userRepository->fetchUserLikeMeData(false)->pluck('by_users__id')->toArray();
        $follower_ids = $this->userRepository->fetchMyLikeDataByUserId( $userId )->pluck('to_users__id')->toArray();

        $followUserIds = array_values(array_unique(array_merge( $follwing_ids, $follower_ids)));  
        $followUsers = [];
        
        $uncontactUserCollection = $this->userRepository->fetchAllRandomFeatureUsers( [], $followUserIds ); 
        if (!\__isEmpty($uncontactUserCollection)) {
            foreach ($uncontactUserCollection as $user) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->_uid]);
                $profilePictureUrl = noThumbImageURL();
                if (!\__isEmpty($user->profile_picture)) {
                    $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $user->profile_picture);
                }
                $followUsers[] = [
                    'user_id'           => $user->_id,
                    'user_uid'          => $user->_uid,
                    'user_full_name'    => $user->userFullName,
                    'user_kanji_name'   => $user->kanji_name,
                    'profile_picture'   => $profilePictureUrl,
                    'role_name'          => $user->role_name,
                ];
            }
        }
        return $this->engineReaction(1, $followUsers);
    }

    public function prepareFollowersList() {
        $userDetails = getUserAuthInfo();
        $userId = array_get($userDetails, 'profile._id');
        $follwing_ids = $this->userRepository->fetchUserLikeMeData(false)->pluck('by_users__id')->toArray();
        $follwing_ids[] = -1;
        $followUsers = [];
        $uncontactUserCollection = $this->userRepository->fetchAllRandomFeatureUsers( [], $follwing_ids ); 
        if (!\__isEmpty($uncontactUserCollection)) {
            foreach ($uncontactUserCollection as $user) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->_uid]);
                $profilePictureUrl = noThumbImageURL();
                if (!\__isEmpty($user->profile_picture)) {
                    $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $user->profile_picture);
                }
                $followUsers[] = [
                    'user_id'           => $user->_id,
                    'user_uid'          => $user->_uid,
                    'username'          => $user->username,
                    'user_full_name'    => $user->userFullName,
                    'user_kanji_name'   => $user->kanji_name,
                    'profile_picture'   => $profilePictureUrl,
                    'role_name'          => $user->role_name,
                    'isMutualLike'   =>  $this->userRepository->checkMutualFollow($user->_id)
                ];
            }
        }
        return $this->engineReaction(1, $followUsers);
    }

    public function prepareFollowingsList() {
        $userDetails = getUserAuthInfo();
        $userId = array_get($userDetails, 'profile._id');
        
        $follower_ids = $this->userRepository->fetchMyLikeDataByUserId( $userId )->pluck('to_users__id')->toArray();
        $follower_ids[] = -1;
        $followUsers = [];
        $uncontactUserCollection = $this->userRepository->fetchAllRandomFeatureUsers( [], $follower_ids ); 
        if (!\__isEmpty($uncontactUserCollection)) {
            foreach ($uncontactUserCollection as $user) {
                $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->_uid]);
                $profilePictureUrl = noThumbImageURL();
                if (!\__isEmpty($user->profile_picture)) {
                    $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $user->profile_picture);
                }
                $followUsers[] = [
                    'user_id'           => $user->_id,
                    'user_uid'          => $user->_uid,
                    'username'          => $user->username,
                    'user_full_name'    => $user->userFullName,
                    'user_kanji_name'   => $user->kanji_name,
                    'profile_picture'   => $profilePictureUrl,
                    'role_name'          => $user->role_name,
                    'isMutualLike'   =>  $this->userRepository->checkMutualFollow($user->_id)
                ];
            }
        }
        return $this->engineReaction(1, $followUsers);
    }

    /**
     * Prepare profile visitors Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareProfileVisitorsData()
    {
        //profile boost all user list
        $isPremiumUser = $this->userRepository->fetchAllPremiumUsers();
        //premium user ids
        $premiumUserIds = $isPremiumUser->pluck('users__id')->toArray();
        //get profile visitor data
        $profileVisitors = $this->userRepository->fetchProfileVisitorData($premiumUserIds);

        $userData = [];
        //check if not empty collection
        if (!__isEmpty($profileVisitors)) {
            foreach ($profileVisitors as $key => $user) {
                //check user browser
                $allowVisitorProfile = getFeatureSettings('browse_incognito_mode', null, $user->userId);

                //check is premium user value is false and in array check premium user exists
                //then data not shown in visitors page
                if (!$allowVisitorProfile and !in_array($user->userId, $premiumUserIds)) {
                    $userImageUrl = '';
                    //check is not empty
                    if (!__isEmpty($user->profile_picture)) {
                        $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->userUId]);
                        $userImageUrl = getMediaUrl($profileImageFolderPath, $user->profile_picture);
                    } else {
                        $userImageUrl = noThumbImageURL();
                    }

                    $userAge = isset($user->dob) ? Carbon::parse($user->dob)->age : null;
                    $gender = isset($user->gender) ? configItem('user_settings.gender', $user->gender) : null;

                    $userData[] = [
                        '_id' => $user->_id,
                        '_uid' => $user->_uid,
                        'status' => $user->status,
                        'like' => $user->like,
                        'created_at' => formatDiffForHumans($user->created_at),
                        'updated_at' => formatDiffForHumans($user->updated_at),
                        'userFullName' => $user->userFullName,
                        'username' => $user->username,
                        'userImageUrl' => $userImageUrl,
                        'profilePicture' => $user->profile_picture,
                        'userOnlineStatus' => $this->getUserOnlineStatus($user->userAuthorityUpdatedAt),
                        'gender' => $gender,
                        'dob' => $user->dob,
                        'userAge' => $userAge,
                        'countryName' => $user->countryName,
                        'isPremiumUser' => isPremiumUser($user->userId),
                        'detailString' => implode(', ', array_filter([$userAge, $gender])),
                    ];
                }
            }
        }

        return $this->engineReaction(1, [
            'usersData' => $userData,
            'nextPageUrl' => $profileVisitors->nextPageUrl(),
        ]);
    }

    /**
     * Prepare User Feed Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareUserFeedData()
    {
        //fetch user liked data by to user id
        $feedCollection = $this->userRepository->fetchUserPhotoDataForLike(); 
        $feedData = [];
        //check if not empty collection
        if (!__isEmpty($feedCollection)) {
            foreach ($feedCollection as $key => $feed) {

                    $userImageUrl = '';
                    //check is not empty
                    if (!__isEmpty($feed->profile_picture)) {
                        $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $feed->userUId]);
                        $userImageUrl = getMediaUrl($profileImageFolderPath, $feed->profile_picture);
                    } else {
                        $userImageUrl = noThumbImageURL();
                    }

                    $photoImageUrl = '';
                    //check is not empty
                    if (!__isEmpty($feed->image_name)) {
                        $photoImageFolderPath = getPathByKey('user_photos', ['{_uid}' => $feed->userUId]);
                        $photoImageUrl = getMediaUrl($photoImageFolderPath, $feed->image_name);
                    } else {
                        $photoImageUrl = noThumbImageURL();
                    }

                    $feedUserData = $this->userRepository->fetchUserFeedData($feed->photo_id, getUserID());
                    
                    $feedCommentDataCollection = $this->userRepository->fetchPhotoCommentData($feed->photo_id);
                    $feedCommentData = [];

                    if (!__isEmpty($feedCommentDataCollection)) {
                        foreach ($feedCommentDataCollection as $itemkey => $itemfeed) {
                            $feeduserImageUrl = '';
                            //check is not empty
                            if (!__isEmpty($itemfeed->profile_picture)) {
                                $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $itemfeed->userUId]);
                                $feeduserImageUrl = getMediaUrl($profileImageFolderPath, $itemfeed->profile_picture);
                            } else {
                                $feeduserImageUrl = noThumbImageURL();
                            }
                            $feedCommentData[] = [
                                'username'  => $itemfeed->username,
                                'comment'   => $itemfeed->user_comment,
                                'comment_date'   => $itemfeed->comment_date,
                                'feeduserImageUrl' => $feeduserImageUrl,
                            ];
                        }
                    }
                    
                    $feedData[] = [
                    'photo_id' => $feed->photo_id,
                    'photo_uid' => $feed->photo_uid,
                    'photo_status' => $feed->photo_status,
                    'photoUpdatedAt' => formatDiffForHumans($feed->photoUpdatedAt),
                    'userFullName' => $feed->userFullName,
                    'username' => $feed->username,
                    'user_id'       => $feed->userId,
                    'kanji_name' => $feed->kanji_name,
                    'userImageUrl' => $userImageUrl,
                    'photoImageUrl' => $photoImageUrl,
                    'profilePicture' => $feed->profile_picture,
                    'user_comment'   => $feed->user_comment,
                    'is_like'        => !__isEmpty($feedUserData)?$feedUserData->is_like:null,
                    'is_tagged'        => !__isEmpty($feedUserData)?$feedUserData->is_tagged:null,
                    'feedCommentData'     => $feedCommentData
                    ];
                
            }
        }

        //$currentPage = $filterDataCollection->currentPage() + 1;
        
        return $this->engineReaction(1, [
            'feedData' => $feedData,
            'nextPageUrl' => $feedCollection->nextPageUrl(),
            'hasMorePages'          => $feedCollection->hasMorePages(),
            'totalCount'            => $feedCollection->total()
        ]);
    }

    /**
     * Prepare User Array Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareUserArray($userCollection)
    {
        $userData = [];
        //check if not empty collection
        if (!__isEmpty($userCollection)) {
            foreach ($userCollection as $key => $user) {
                $userImageUrl = '';
                //check is not empty
                if (!__isEmpty($user->profile_picture)) {
                    $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->userUId]);
                    $userImageUrl = getMediaUrl($profileImageFolderPath, $user->profile_picture);
                } else {
                    $userImageUrl = noThumbImageURL();
                }

                $userAge = isset($user->dob) ? Carbon::parse($user->dob)->age : null;
                $gender = isset($user->gender) ? configItem('user_settings.gender', $user->gender) : null;

                $userData[] = [
                    '_id' => $user->_id,
                    '_uid' => $user->_uid,
                    'status' => $user->status,
                    'like' => $user->like,
                    'created_at' => formatDiffForHumans($user->created_at),
                    'updated_at' => formatDiffForHumans($user->updated_at),
                    'userFullName' => $user->userFullName,
                    'username' => $user->username,
                    'userImageUrl' => $userImageUrl,
                    'profilePicture' => $user->profile_picture,
                    'userOnlineStatus' => $this->getUserOnlineStatus($user->userAuthorityUpdatedAt),
                    'gender' => $gender,
                    'dob' => $user->dob,
                    'userAge' => $userAge,
                    'countryName' => $user->countryName,
                    'isPremiumUser' => isPremiumUser($user->userId),
                    'detailString' => implode(', ', array_filter([$userAge, $gender])),
                ];
            }
        }

        return $userData;
    }

    /**
     * Process User Send Gift.
     *
     *-----------------------------------------------------------------------*/
    public function processUserSendGift($inputData, $sendUserUId)
    {
        //buy premium plan request
        $userSendGiftRequest = $this->userRepository->processTransaction(function () use ($inputData, $sendUserUId) {
            //fetch user
            $user = $this->userRepository->fetch($sendUserUId);

            //if user not exists
            if (__isEmpty($user)) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('User does not exists.'));
            }

            //fetch gift data
            $giftData = $this->manageItemRepository->fetch($inputData['selected_gift']);

            //if gift not exists
            if (__isEmpty($giftData)) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Gift data does not exists.'));
            }

            //fetch user credits data
            $totalUserCredits = totalUserCredits();

            //if gift price greater then total user credits then show error message
            if ($giftData->normal_price > $totalUserCredits) {
                return $this->userRepository->transactionResponse(2, [
                    'show_message' => true,
                    'errorType' => 'insufficient_balance',
                ], __tr('Your credit balance is too low, please purchase credits.'));
            }
            //check user is premium or normal or Set price
            if (isPremiumUser()) {
                $credits = $giftData->premium_price;
            } else {
                $credits = $giftData->normal_price;
            }
            //credit wallet store data
            $creditWalletStoreData = [
                'status' => 1,
                'users__id' => getUserID(),
                'credits' => '-'.''.$credits,
            ];

            //store user gift data
            if ($creditWalledId = $this->userRepository->storeCreditWalletTransaction($creditWalletStoreData)) {
                //store gift data
                $giftStoreData = [
                    'status' => (isset($inputData['isPrivateGift'])
                        and $inputData['isPrivateGift'] == 'on') ? 1 : 0,
                    'from_users__id' => getUserID(),
                    'to_users__id' => $user->_id,
                    'items__id' => $giftData->_id,
                    'price' => $giftData->normal_price,
                    'credit_wallet_transactions__id' => $creditWalledId,
                ];

                //store gift data
                if ($this->userRepository->storeUserGift($giftStoreData)) {
                    $userFullName = $user->first_name.' '.$user->last_name;
                    activityLog($userFullName.' '.'send gift.');
                    //loggedIn user name
                    $loggedInUserName = Auth::user()->first_name.' '.Auth::user()->last_name;
                    //notification log message
                    notificationLog('Gift send by'.' '.$loggedInUserName, route('user.profile_view', ['username' => Auth::user()->username]), null, $user->_id, getUserID(),'user-gift');

                    //push data to pusher
                    PushBroadcast::notifyViaPusher('event.user.notification', [
                        'type' => 'user-gift',
                        'userUid' => $user->_uid,
                        'subject' => __tr('Gift send successfully'),
                        'message' => __tr('Gift send by').' '.$loggedInUserName,
                        'messageType' => 'success',
                        'showNotification' => getUserSettings('show_gift_notification', $user->_id),
                        'getNotificationList' => getNotificationList($user->_id),
                    ]);

                    return $this->userRepository->transactionResponse(1, [
                        'show_message' => true,
                        'giftUid' => $giftData->_uid,
                    ], __tr('Gift send successfully.'));
                }
            }
            //error message
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Gift not send.'));
        });

        //response
        return $this->engineReaction($userSendGiftRequest);
    }

    /**
     * Process Report User.
     *
     *-----------------------------------------------------------------------*/
    public function processReportUser($inputData)
    {
        //fetch user
        $user = $this->userRepository->fetch($inputData["sendUserUId"]);

        //if user not exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User does not exists.'));
        }

        //fetch reported user data
        $reportUserData = $this->manageAbuseReportRepository->fetchAbuseReport($user->_id);

        //if exist then throw error message
        if (!__isEmpty($reportUserData)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User already abuse reported.'));
        }

        //store report data
        $storeReportData = [
            'status' => 1,
            'for_users__id' => $user->_id,
            'by_users__id' => getUserID(),
            'reason' => $inputData['report_reason'],
        ];
        // store report data
        if ($this->manageAbuseReportRepository->storeReportUser($storeReportData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('User abuse reported successfully.'));
        }

        //error message
        return $this->engineReaction(1, ['show_message' => true], __tr('User failed to abuse report.'));
    }

    /**
     * Process Post Review of User.
     *
     *-----------------------------------------------------------------------*/
    public function processPostReviewUser($inputData, $sendUserUId)
    {
        //fetch user
        $user = $this->userRepository->fetch($sendUserUId);

        //if user not exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User does not exists.'));
        }

        //fetch reviewed user data
        $reviewUserData = $this->manageReviewRepository->fetchReview($user->_id);

        //if exist then throw error message
        if (!__isEmpty($reviewUserData)) {
            //return $this->engineReaction(2, ['show_message' => true], __tr('User already posted review.'));

            //store review data
            $storeReviewData = [
                'rate_value' => $inputData['review_rate_value'],
                'review_comment' => $inputData['review_comment'],
            ];
            // store review data
            if ($reviewUserData->modelUpdate($storeReviewData)) {

                $loggedInUser = Auth::user();
                //loggedIn user name
                $loggedInUserName = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;

                if( $loggedInUserName == " "){
                    $userInfo = getUserAuthInfo();
                    $loggedInUserName = array_get($userInfo, 'profile.full_name');
                }

                notificationLog($loggedInUserName.' has just left a review, click to check it out. ', route('user.profile_view', ['username' => $user->username]), null, $user->_id, getUserID(), "post-review");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'post-review',
                    'userUid' => $user->_id,
                    'subject' => __tr('Post a review'),
                    'message' => $loggedInUserName.__tr(' has just left a review. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $user->_id),
                    'getNotificationList' => getNotificationList($user->_id),
                ]);

                return $this->engineReaction(1, [
                    'show_message' => true,
                    'rate_value' => $inputData['review_rate_value'],
                    'review_comment' => $inputData['review_comment']
                ], __tr('User review posted successfully.'));
            }
        } else {

            //store review data
            $storeReviewData = [
                'status' => 1,
                'to_users__id' => $user->_id,
                'by_users__id' => getUserID(),
                'rate_value' => $inputData['review_rate_value'],
                'review_comment' => $inputData['review_comment'],
            ];
            // store review data
            if ($this->manageReviewRepository->storeReviewUser($storeReviewData)) {

                $loggedInUser = Auth::user();
                //loggedIn user name
                $loggedInUserName = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;
                if( $loggedInUserName == " "){
                    $userInfo = getUserAuthInfo();
                    $loggedInUserName = array_get($userInfo, 'profile.full_name');
                }
                notificationLog($loggedInUserName.' has just left a review, click to check it out. ', route('user.profile_view', ['username' => $user->username]), null, $user->_id, getUserID(), "post-review");

                //push data to pusher
                PushBroadcast::notifyViaPusher('event.user.notification', [
                    'type' => 'post-review',
                    'userUid' => $user->_id,
                    'subject' => __tr('Post a review'),
                    'message' => $loggedInUserName.__tr(' has just left a review. '),
                    'messageType' => __tr('success'),
                    'showNotification' => getUserSettings('show_user_login_notification', $user->_id),
                    'getNotificationList' => getNotificationList($user->_id),
                ]);

                return $this->engineReaction(1, [
                    'show_message' => true,
                    'rate_value' => $inputData['review_rate_value'],
                    'review_comment' => $inputData['review_comment']
                ], __tr('User review posted successfully.'));
            }
        }

        //error message
        return $this->engineReaction(1, ['show_message' => true], __tr('User failed to post review.'));
    }

    public function processRequestSupport($inputData)
    {
        
        //store review data
        $storeData = [
            'status' => 1,
            'users__id' => getUserID(),
            'type' => $inputData['support_type'],
            'description' => $inputData['description'],
        ];
        // store review data
        if ($this->manageSupportRequestRepository->store($storeData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('User support requested successfully.'));
        }

        //error message
        return $this->engineReaction(1, ['show_message' => true], __tr('User failed to request support.'));
    }

    public function processPostPhoto($inputData)
    {
        //fetch user
        $userId = getUserID();
        $user = $this->userRepository->fetch($userId);

        //if user not exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User does not exists.'));
        }

        $userPhotosCollection = $this->userSettingRepository->fetchUserPhotos($userId);
        if( count($userPhotosCollection) > 8) {
            return $this->engineReaction(2, ['show_message' => true], __tr('User posted already 9 photos.'));
        }

        //store photo data
        $userPhotoData = [
            'status' => 1,
            'users__id' => getUserID(),
            'comment' => $inputData['photo_comment'],
            'tagged_users_id' => $inputData['post_tagged_users'],
        ];

        // store profile image
        $fileName = '';
        $base64Image = $inputData['post_photo_blob'];
        $uploadedFileOnLocalServer = $this->mediaEngine->processSaveBase64ImageToLocalServer($base64Image, 'photos', authUID(),"photos");
        $isFileUploaded = false;

        if ($uploadedFileOnLocalServer['reaction_code'] == 1) {
            $uploadedFileData = $uploadedFileOnLocalServer['data'];
            $fileName = $uploadedFileData['fileName'];
            $isFileUploaded = true;
            $userPhotoData["file"] = $fileName;
        } else {
            return $uploadedFileOnLocalServer;
        }
            
        // store photo data
        if ($newUserPhoto = $this->userSettingRepository->storeUserPhoto($userPhotoData)) {

            /*
            $loggedInUser = Auth::user();
            //loggedIn user name
            $loggedInUserName = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;
            notificationLog($loggedInUserName.' has just posted a photo, click to check it out. ', route('user.profile_view', ['username' => $user->username]), null, $user->_id, getUserID(), "review");

            //push data to pusher
            PushBroadcast::notifyViaPusher('event.user.notification', [
                'type' => 'user-login',
                'userUid' => $user->_id,
                'subject' => __tr('Post a review'),
                'message' => $loggedInUserName.__tr(' has just left a review. '),
                'messageType' => __tr('success'),
                'showNotification' => getUserSettings('show_user_login_notification', $user->_id),
                'getNotificationList' => getNotificationList($user->_id),
            ]);
            */
            $userInfo = getUserAuthInfo();
            $fullName = array_get($userInfo, 'profile.full_name');
            activityLog($fullName.' upload new photos.');
            $likePhotoUrl = route('user.upload_photos.write.like', ['photoUid' => $newUserPhoto->_uid]);
            $taggedPhotoUrl = route('user.upload_photos.write.tagged', ['photoUid' => $newUserPhoto->_uid]);
            return $this->engineReaction(1, [
                'stored_photo' => [
                    '_id' => $newUserPhoto->_id,
                    'photoUId' => $newUserPhoto->_uid,
                    'is_like' => $newUserPhoto->is_like,
                    'is_tagged' => $newUserPhoto->is_tagged,
                    'user_comment' => $newUserPhoto->comment ,
                    'removePhotoUrl' => route('user.upload_photos.write.delete', ['photoUid' => $newUserPhoto->_uid]),
                    'likePhotoUrl' => $likePhotoUrl,
                    'taggedPhotoUrl' => $taggedPhotoUrl,
                    'image_url' => $uploadedFileData['path'],
                    'photo_user_id' => getUserID(),
                    'created_at'  => date("Y-m-d H:i:s")
                ],
            ], __tr('Photos uploaded successfully.'));
        }

        //error message
        return $this->engineReaction(1, ['show_message' => true], __tr('User failed to post photo.'));
    }


    public function preparePhotoInfo($inputData, $photoUId){

        $photo = $this->userSettingRepository->fetchPhotosByUId($photoUId);
        // Check if user exists
        if (__isEmpty($photo)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('Photo does not exists.'));
        }

        $user_id = $inputData['photo_user_id'];
        $user = $this->userRepository->fetch($user_id);
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        // fetch User details
        $userProfile = $this->userSettingRepository->fetchUserProfile($user_id);
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $user->_uid]);
        $profilePictureUrl = noThumbImageURL();
        
        // Check if user profile exists
        if (!__isEmpty($userProfile)) {
            if (!__isEmpty($userProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userProfile->profile_picture);
            }
        }


        $feedData = $this->userRepository->fetchUserFeedData($photo->_id);
        $feedCommentDataCollection = $this->userRepository->fetchPhotoCommentData($photo->_id);
        $feedCommentData = [];
        if (!__isEmpty($feedCommentDataCollection)) {
            foreach ($feedCommentDataCollection as $itemkey => $itemfeed) {
                $feeduserImageUrl = '';
                //check is not empty
                if (!__isEmpty($itemfeed->profile_picture)) {
                    $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $itemfeed->userUId]);
                    $feeduserImageUrl = getMediaUrl($profileImageFolderPath, $itemfeed->profile_picture);
                } else {
                    $feeduserImageUrl = noThumbImageURL();
                }
                $feedCommentData[] = [
                    'username'  => $itemfeed->username,
                    'comment'   => $itemfeed->user_comment,
                    'comment_date'   => $itemfeed->comment_date,
                    'feeduserImageUrl' => $feeduserImageUrl,
                ];
            }
        }
        
        return $this->engineReaction(1, [
            'is_like' => __isEmpty($feedData)?null:$feedData->is_like,
            'is_tagged' => __isEmpty($feedData)?null:$feedData->is_tagged,
            'photo_uid'  => $photoUId,
            'feedCommentData'  => $feedCommentData,
            'fullName' => $userProfile->kanji_name.' '.$userProfile->kata_name,
            'kanji_name' => $userProfile->kanji_name,
            'userName' => $user->username,
            'profilePictureUrl'   => $profilePictureUrl
        ]);
    }

    /**
     * Process Block User.
     *
     *-----------------------------------------------------------------------*/
    public function processBlockUser($inputData)
    {
        //fetch user
        $user = $this->userRepository->fetch($inputData['block_user_id']);

        //if user not exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, null, __tr('User does not exists.'));
        }

        //fetch block user data
        $blockUserData = $this->userRepository->fetchBlockUser($user->_id);

        //check is not empty
        if (!__isEmpty($blockUserData)) {
            //error response
            return $this->engineReaction(2, null, __tr('You are already block this user.'));
        }

        //store data
        $storeData = [
            'status' => 1,
            'to_users__id' => $user->_id,
            'by_users__id' => getUserID(),
        ];

        //store block user data
        if ($this->userRepository->storeBlockUser($storeData)) {
            //user full name
            $userFullName = $user->first_name.' '.$user->last_name;
            //loggedIn user name
            $loggedInUserName = Auth::user()->first_name.' '.Auth::user()->last_name;
            //activity log message
            activityLog($loggedInUserName.' '.'blocked by.'.' '.$userFullName);

            // Removing following 

            $likeDislikeData = $this->userRepository->fetchLikeDislike($user->_id);
            $likeDislikeDataMe = $this->userRepository->fetchLikeDislikeToMe($user->_id);
            if( !__isEmpty($likeDislikeData) )
                $this->userRepository->deleteLikeDislike($likeDislikeData ,false);
            if( !__isEmpty($likeDislikeDataMe) )
                $this->userRepository->deleteLikeDislike($likeDislikeDataMe ,false);
           
            //success response
            return $this->engineReaction(1, null, __tr('Blocked user successfully.'));
        }
        //error response
        return $this->engineReaction(2, null, __tr('User not block.'));
    }

    /**
     * Prepare Block User Data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareBlockUserData()
    {
        $blockUserCollection = $this->userRepository->fetchAllBlockUser(true);

        $blockUserList = [];
        //check if not empty
        if (!__isEmpty($blockUserCollection)) {
            foreach ($blockUserCollection as $key => $blockUser) {
                $userImageUrl = '';
                //check is not empty
                if (!__isEmpty($blockUser->profile_picture)) {
                    $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $blockUser->userUId]);
                    $userImageUrl = getMediaUrl($profileImageFolderPath, $blockUser->profile_picture);
                } else {
                    $userImageUrl = noThumbImageURL();
                }

                $userAge = isset($blockUser->dob) ? Carbon::parse($blockUser->dob)->age : null;
                $gender = isset($blockUser->gender) ? configItem('user_settings.gender', $blockUser->gender) : null;

                $blockUserList[] = [
                    '_id' => $blockUser->_id,
                    '_uid' => $blockUser->_uid,
                    'userId' => $blockUser->userId,
                    'userUId' => $blockUser->userUId,
                    'userFullName' => $blockUser->userFullName,
                    'status' => $blockUser->status,
                    'created_at' => formatDiffForHumans($blockUser->created_at),
                    'userOnlineStatus' => $this->getUserOnlineStatus($blockUser->userAuthorityUpdatedAt),
                    'username' => $blockUser->username,
                    'userImageUrl' => $userImageUrl,
                    'profilePicture' => $blockUser->profile_picture,
                    'gender' => $gender,
                    'dob' => $blockUser->dob,
                    'userAge' => $userAge,
                    'countryName' => $blockUser->countryName,
                    'isPremiumUser' => isPremiumUser($blockUser->userId),
                    'detailString' => implode(', ', array_filter([$userAge, $gender])),
                ];
            }
        }

        //success reaction
        return $this->engineReaction(1, [
            'usersData' => $blockUserList,
            'nextPageUrl' => $blockUserCollection->nextPageUrl(),
        ]);
    }

    /**
     *Process unblock user.
     *
     *-----------------------------------------------------------------------*/
    public function processUnblockUser($inputData)
    {
        //fetch user
        $user = $this->userRepository->fetch($inputData['block_user_id']);

        //if user not exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, null, __tr('User does not exists.'));
        }

        //fetch block user data
        $blockUserData = $this->userRepository->fetchBlockUser($user->_id);

        //if it is empty
        if (__isEmpty($blockUserData)) {
            return $this->engineReaction(2, null, __tr('Block user does not exists.'));
        }

        //delete block user
        if ($this->userRepository->deleteBlockUser($blockUserData)) {
            //user full name
            $userFullName = $user->first_name.' '.$user->last_name;
            //loggedIn user name
            $loggedInUserName = Auth::user()->first_name.' '.Auth::user()->last_name;
            //activity log message
            activityLog($loggedInUserName.' '.'Unblock by.'.' '.$userFullName);
            //success response
            return $this->engineReaction(1, [
                'blockUserUid' => $blockUserData->_uid,
                'blockUserLength' => $this->userRepository->fetchAllBlockUser()->count(),
            ], __tr('User has been unblock successfully.'));
        }

        //error response
        return $this->engineReaction(2, null, __tr('Failed to unblock user.'));
    }

    /**
     *	Process Boost Profile.
     *
     *-----------------------------------------------------------------------*/
    public function processBoostProfile()
    {
        $transactionResponse = $this->userRepository->processTransaction(function () {
            $user = Auth::user();

            //fetch user
            $activeBoost = $this->userRepository->fetchActiveProfileBoost($user->_id);

            $remainingTime = 0;

            if (!__isEmpty($activeBoost)) {
                $remainingTime = Carbon::now()->diffInSeconds($activeBoost->expiry_at, false);
            }

            $totalUserCredits = totalUserCredits();
            $boostPeriod = getStoreSettings('booster_period');
            $boostPrice = getStoreSettings('booster_price');

            if (isPremiumUser()) {
                $boostPrice = getStoreSettings('booster_price_for_premium_user');
            }

            if ($totalUserCredits < $boostPrice) {
                return $this->userRepository->transactionResponse(2, [
                    'show_message' => true,
                    'creditsRemaining' => totalUserCredits(),
                ], __tr('Enough credits are not available. Please buy some credits'));
            }

            //credit wallet store data
            $creditWalletStoreData = [
                'status' => 1,
                'users__id' => $user->_id,
                'credits' => '-'.''.$boostPrice,
            ];

            //store user gift data
            if ($creditWalledId = $this->userRepository->storeCreditWalletTransaction($creditWalletStoreData)) {
                $boosterData = [
                    'for_users__id' => $user->_id,
                    'expiry_at' => Carbon::now()->addSeconds(($remainingTime + ($boostPeriod * 60))),
                    'status' => 1,
                    'credit_wallet_transactions__id' => $creditWalledId,
                ];

                if ($booster = $this->userRepository->storeBooster($boosterData)) {
                    //activity log message
                    activityLog(strtr('Booster activated by user __firstName__ __lastName__', [
                        '__firstName__' => $user->first_name,
                        '__lastName__' => $user->last_name,
                    ]));

                    //fetch user
                    $activeBoost = $this->userRepository->fetchActiveProfileBoost($user->_id);

                    //success response
                    return $this->userRepository->transactionResponse(1, [
                        'show_message' => true,
                        'boosterExpiry' => Carbon::now()->diffInSeconds($activeBoost->expiry_at, false),
                        'creditsRemaining' => totalUserCredits(),
                    ], __tr('Booster activated successfully'));
                }
            }

            //error response
            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Failed to boost profile.'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     *	Check profile status.
     *
     *-----------------------------------------------------------------------*/
    public function checkProfileStatus()
    {
        $userId = getUserID();
        $user = $this->userRepository->fetch($userId);

        //get profile
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        if (__isEmpty($userProfile)) {
            $userProfile = $this->userRepository->storeUserProfile([
                'users__id' => $userId,
                'status' => 1,
                'user_roles__id' => $user->user_role_id
            ]);
        }

        $steps = configItem('profile_update_wizard');

        if ($userProfile->status == 2) {
            $profileStatus = [
                'step_one' => true,
                'step_two' => true,
            ];
        } else {
            //check if co-ordinates are set
            if ((__isEmpty($userProfile['location_longitude'])
                    or $userProfile['location_longitude'] == 0)
                and (__isEmpty($userProfile['location_latitude'])
                    or $userProfile['location_latitude'] == 0)
            ) {
                $profileStatus['step_two'] = false;
            } else {
                $profileStatus['step_two'] = true;
            }

            //for step one
            $profileStatus['step_one'] = $this->isStepCompleted($userProfile->toArray(), $steps['step_one']);
        }

        //preview options
        $profileInfo = [
            'profile_picture_url' => null,
            'cover_picture_url' => null,
            'gender' => $userProfile['gender'],
            'birthday' => $userProfile['dob'],
            'location_longitude' => isset($userProfile['location_longitude']) ? floatval($userProfile['location_longitude']) : null,
            'location_latitude' => isset($userProfile['location_latitude']) ? floatval($userProfile['location_latitude']) : null,
        ];

        $userUID = authUID();

        //profile pic
        if (isset($userProfile['profile_picture']) and !__isEmpty($userProfile['profile_picture'])) {
            //path
            $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $userUID]);
            // url
            $profileInfo['profile_picture_url'] = getMediaUrl($profilePictureFolderPath, $userProfile['profile_picture']);
        }

        //cover photo
        if (isset($userProfile['cover_picture']) and !__isEmpty($userProfile['cover_picture'])) {
            //path
            $coverPictureFolderPath = getPathByKey('cover_photo', ['{_uid}' => $userUID]);
            // url
            $profileInfo['cover_picture_url'] = getMediaUrl($coverPictureFolderPath, $userProfile['cover_picture']);
        }

        $user_time = $this->userRepository->getUserAvailability($userId);

        return $this->engineReaction(1, [
            'user_role' => $user->user_role_id,
            'profileStatus' => $profileStatus,
            'profileInfo' => $profileInfo,
            'genders' => configItem('user_settings.gender'),
            'profileMediaRestriction' => getMediaRestriction('profile'),
            'coverImageMediaRestriction' => getMediaRestriction('cover_image'),
            'userAvailability'    => $user_time
        ]);
    }

    /**
     *	Check profile status.
     *
     *-----------------------------------------------------------------------*/
    public function finishWizard()
    {
        //get profile
        $userProfile = $this->userSettingRepository->fetchUserProfile(getUserID());

        if ($this->userRepository->updateProfile($userProfile, ['status' => 2]) || $userProfile->status == 2) {
            return $this->engineReaction(1, [
                'redirectURL' => route('user.profile_view', ['username' => getUserAuthInfo('profile.username')]),
            ], __tr('Wizard completed successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Failed to complete profile'));
    }

    /**
     *	check if step completed.
     *
     *-----------------------------------------------------------------------*/
    private function isStepCompleted($profile, $stepFields)
    {
        if (!__isEmpty($profile)) {
            foreach ($profile as $key => $value) {
                if (in_array($key, $stepFields)) {
                    if (__isEmpty($profile[$key])) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Process user contact request.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processContact($inputData)
    {
        //contact email data
        $emailData = [
            'userName' => $inputData['fullName'],
            'senderEmail' => $inputData['email'],
            'toEmail' => getStoreSettings('contact_email'),
            'subject' => $inputData['subject'],
            'messageText' => $inputData['message'],
        ];

        // check if email send to member
        if ($this->baseMailer->notifyAdmin($inputData['subject'], 'contact', $emailData, 2)) {
            //success response
            return $this->engineReaction(1, ['show_message' => true], __tr('Mail has been sent successfully, we contact soon.'));
        }
        //error response
        return $this->engineReaction(2, ['show_message' => true], __tr('Failed to send mail.'));
    }

    /**
     * Process user contact request.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function getBoosterInfo()
    {
        return $this->engineReaction(1, [
            'booster_period' => __tr(getStoreSettings('booster_period')),
            'booster_price' => __tr((isPremiumUser()) ? getStoreSettings('booster_price_for_premium_user') : getStoreSettings('booster_price')),
        ]);
    }

    /**
     * Process delete account.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processDeleteAccount($inputData)
    {
        $user = $this->userRepository->fetchByID(getUserID());

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        if (!Hash::check($inputData['password'], $user->password)) {
            return $this->engineReaction(3, ['show_message' => true], __tr('Current password is incorrect.'));
        }

        // Delete all media of user
        $deletedMedia = $this->mediaEngine->deleteUserAccount();

        // Delete account successfully
        if ($this->userRepository->deleteUser($user)) {
            // Process Logout user
            $this->processLogout();

            return $this->engineReaction(1, ['show_message' => true], __tr('Your account has been deleted successfully.'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Account not deleted.'));
    }

    /**
     * Process delete account.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function resendActivationMail($inputData)
    {
        $user = $this->userRepository->fetchByEmail($inputData['email']);

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('You are not a member of this system.'));
        }

        // Check if user exists
        if ($user->status == 1) {
            return $this->engineReaction(18, ['show_message' => true], __tr('Account already activated.'));
        }

        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData, $user) {
            // Delete account successfully
            if ($updatedUser = $this->userRepository->updateUser($user, [
                'remember_token' => Utils::generateStrongPassword(4, false, 'ud'),
            ])) {
                $emailData = [
                    'fullName' => $user->first_name,
                    'email' => $user->email,
                    'expirationTime' => configItem('otp_expiry'),
                    'otp' => $updatedUser->remember_token,
                ];

                // check if email send to member
                if ($this->baseMailer->notifyToUser('Activation mail sent.', 'account.activation-for-app', $emailData, $user->email)) {
                    return $this->userRepository->transactionResponse(1, [
                        'show_message' => true,
                        'activation_mail_sent' => true,
                    ], __tr('Activation mail sent successfully, to activate your account please check your email.'));
                }

                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Failed to send activation mail'));
            }
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process verify otp.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function verifyOtpProcess($inputData, $type)
    {
        // exit;
        $user = $this->userRepository->fetchByEmail($inputData['email']);

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('You are not a member of this system.'));
        }

        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData, $user, $type) {
            if ($type == 1) {
                $neverActivatedUser = $this->userRepository->fetchNeverActivatedUserForApp($inputData['email']);

                // Check if never activated user exist or not
                if (__isEmpty($neverActivatedUser)) {
                    return $this->userRepository->transactionResponse(18, null, __tr('Invalid OTP'));
                }

                if ($user->remember_token == $inputData['otp']) {
                    $updatedUser = $this->userRepository->updateUser($user, ['remember_token' => null, 'status' => 1]);

                    return $this->userRepository->transactionResponse(1, [
                        'show_message' => true,
                    ], __tr('Otp verified successfully.'));
                }
            } elseif ($type == 2) {
                $passwordReset = $this->userRepository->fetchPasswordReset($inputData['otp']);

                if (__isEmpty($passwordReset)) {
                    return $this->userRepository->transactionResponse(18, null, __tr('Invalid OTP'));
                }

                return $this->userRepository->transactionResponse(1, [
                    'show_message' => true,
                    'account_verified' => true,
                ], __tr('OTP verified successfully.'));
            }

            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Invalid OTP'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process delete account.
     *
     * @param array $inputData
     *
     * @return array
     *---------------------------------------------------------------- */
    public function requestNewPassword($inputData)
    {
        $user = $this->userRepository->fetchByEmail($inputData['email']);

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('You are not a member of this system.'));
        }

        // Check if user exists
        if ($user->status != 1) {
            return $this->engineReaction(18, [
                'show_message' => true,
            ], __tr('Your account might be Inactive, Blocked or Not Activated.'));
        }

        $transactionResponse = $this->userRepository->processTransaction(function () use ($inputData, $user) {
            // Delete old password reminder for this user
            $this->userRepository->appDeleteOldPasswordReminder($inputData['email']);

            $currentDateTime = Carbon::now();
            $token = Utils::generateStrongPassword(4, false, 'ud');
            $createdAt = $currentDateTime->addSeconds(configItem('otp_expiry'));

            $storeData = [
                'email' => $inputData['email'],
                'token' => $token,
                'created_at' => $createdAt,
            ];

            // Check for if password reminder added
            if (!$this->userRepository->storePasswordReminder($storeData)) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Invalid Request.'));
            }

            $otpExpiry = configItem('otp_expiry');
            $differenceSeconds = Carbon::now()->diffInSeconds($createdAt, false);
            $newExpiryTime = 0;
            if ($differenceSeconds > 0 and $differenceSeconds < $otpExpiry) {
                $newExpiryTime = $differenceSeconds;
            }

            $emailData = [
                'fullName' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                'expirationTime' => config('__tech.account.app_password_reminder_expiry'),
                'otp' => $token,
            ];

            // check if email send to member
            if ($this->baseMailer->notifyToUser('OTP sent.', 'account.forgot-password-for-app', $emailData, $user->email)) {
                return $this->userRepository->transactionResponse(1, [
                    'show_message' => true,
                    'mail_sent' => true,
                    'newExpiryTime' => $newExpiryTime,
                ], __tr('OTP sent successfully, to reset password use OTP sent to your email.'));
            }

            return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Failed to send OTP'));
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process Forgot Password resend otp request.
     *
     * @param $userEmail array - userEmail data
     *
     * @return json object
     */
    public function processForgotPasswordResendOtp($userEmail)
    {
        $transactionResponse = $this->userRepository->processTransaction(function () use ($userEmail) {
            $user = $this->userRepository->fetchActiveUserByEmail($userEmail);

            // Check if empty then return error message
            if (__isEmpty($user)) {
                return $this->userRepository->transactionResponse(2, null, 'You are not a member of the system, Please go and register first , then you can proceed for login.');
            }

            // Delete old password reminder for this user
            $this->userRepository->appDeleteOldPasswordReminder($user->email);

            //check if mobile app request then change request Url
            $currentDateTime = Carbon::now();
            $token = Utils::generateStrongPassword(4, false, 'ud');
            $createdAt = $currentDateTime->addSeconds(configItem('otp_expiry'));

            $storeData = [
                'email' => $user->email,
                'token' => $token,
                'created_at' => $createdAt,
            ];

            // Check for if password reminder added
            if (!$this->userRepository->storePasswordReminder($storeData)) {
                return $this->userRepository->transactionResponse(2, ['show_message' => true], __tr('Invalid Request.'));
            }

            $emailData = [
                'fullName' => $user->first_name,
                'email' => $user->email,
                'expirationTime' => config('__tech.account.app_password_reminder_expiry'),
                'otp' => $token,
            ];

            $otpExpiry = configItem('otp_expiry');
            $differenceSeconds = Carbon::now()->diffInSeconds($createdAt, false);
            $newExpiryTime = 0;
            if ($differenceSeconds > 0 and $differenceSeconds < $otpExpiry) {
                $newExpiryTime = $differenceSeconds;
            }

            // check if email send to member
            if ($this->baseMailer->notifyToUser('OTP sent.', 'account.forgot-password-for-app', $emailData, $user->email)) {
                return $this->userRepository->transactionResponse(1, [
                    'show_message' => true,
                    'mail_sent' => true,
                    'newExpiryTime' => $newExpiryTime,
                ], __tr('OTP sent successfully, to reset password use OTP sent to your email.'));
            }

            return $this->userRepository->transactionResponse(2, null, 'Invalid Request'); // error reaction
        });

        return $this->engineReaction($transactionResponse);
    }

    /**
     * Process reset password request.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function resetPasswordForApp($input)
    {
        $email = $input['email'];

        //fetch active user by email
        $user = $this->userRepository->fetchActiveUserByEmail($email);

        // Check if user record exist
        if (__isEmpty($user)) {
            return  $this->engineReaction(18, ['show_message' => true], __tr('Invalid Request.'));
        }

        // Check if user password updated
        if ($this->userRepository->resetPassword($user, $input['password'])) {
            return  $this->engineReaction(1, [
                'show_message' => true,
                'password_changed' => true,
            ], __tr('Password reset successfully.'));
        }

        //failed response
        return  $this->engineReaction(2, ['show_message' => true], __tr('Password not updated.'));
    }

    /**
     * prepare profile details.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareProfileDetails($username)
    {
        // fetch User by username
        $user = $this->userRepository->fetchByUsername($username, true);

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $userId = $user->_id;
        $userUid = $user->_uid;
        $isOwnProfile = ($userId == getUserID()) ? true : false;
        // Prepare user data
        $userData = [
            'userId' => $userId,
            'userUId' => $userUid,
            'fullName' => $user->first_name.' '.$user->last_name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile_number' => $user->mobile_number,
            'userName' => $user->username,
            'userOnlineStatus' => $this->getUserOnlineStatus($user->userAuthorityUpdatedAt),
        ];

        $userProfileData = $userSpecifications = $userSpecificationData = $photosData = [];

        // fetch User details
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);
        $userSettingConfig = configItem('user_settings');
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $userUid]);
        $profilePictureUrl = noThumbImageURL();
        $coverPictureFolderPath = getPathByKey('cover_photo', ['{_uid}' => $userUid]);
        $coverPictureUrl = noThumbCoverImageURL();

        // Check if user profile exists
        if (!__isEmpty($userProfile)) {
            if (!__isEmpty($userProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userProfile->profile_picture);
            }
            if (!__isEmpty($userProfile->cover_picture)) {
                $coverPictureUrl = getMediaUrl($coverPictureFolderPath, $userProfile->cover_picture);
            }
        }

        // Set cover and profile picture url
        $userData['profilePicture'] = $profilePictureUrl;
        $userData['coverPicture'] = $coverPictureUrl;
        $userData['userAge'] = isset($userProfile->dob) ? Carbon::parse($userProfile->dob)->age : null;

        // check if user profile exists
        if (!__isEmpty($userProfile)) {
            // Get country name
            $countryName = '';
            if (!__isEmpty($userProfile->countries__id)) {
                $country = $this->countryRepository->fetchById($userProfile->countries__id, ['name']);
                $countryName = $country->name;
            }
            $userProfileData = [
                'aboutMe' => $userProfile->about_me,
                'city' => $userProfile->city,
                'mobile_number' => $user->mobile_number,
                'gender' => $userProfile->gender,
                'gender_text' => array_get($userSettingConfig, 'gender.'.$userProfile->gender),
                'country' => $userProfile->countries__id,
                'country_name' => $countryName,
                'dob' => $userProfile->dob,
                'birthday' => (!\__isEmpty($userProfile->dob))
                    ? formatDate($userProfile->dob)
                    : '',
                'work_status' => $userProfile->work_status,
                'formatted_work_status' => array_get($userSettingConfig, 'work_status.'.$userProfile->work_status),
                'education' => $userProfile->education,
                'formatted_education' => array_get($userSettingConfig, 'educations.'.$userProfile->education),
                'preferred_language' => $userProfile->preferred_language,
                'formatted_preferred_language' => array_get($userSettingConfig, 'preferred_language.'.$userProfile->preferred_language),
                'relationship_status' => $userProfile->relationship_status,
                'formatted_relationship_status' => array_get($userSettingConfig, 'relationship_status.'.$userProfile->relationship_status),
                'latitude' => isset($userProfile->location_latitude) ? floatval($userProfile->location_latitude) : null,
                'longitude' => isset($userProfile->location_longitude) ? floatval($userProfile->location_longitude) : null,
                'formatted_address'  => $userProfile->formatted_address,
                'isVerified' => $userProfile->is_verified,
            ];
        }

        // Get user photos collection
        $userPhotosCollection = $this->userSettingRepository->fetchUserPhotos($userId);
        $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => authUID()]);
        // check if user photos exists
        if (!__isEmpty($userPhotosCollection)) {
            foreach ($userPhotosCollection as $userPhoto) {
                $photosData[] = [
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->file),
                    'is_like'   => $userPhoto->is_like,
                    'is_tagged' => $userPhoto->is_tagged
                ];
            }
        }

        $likePhotosdata = [];
        // Get user photos collection
        $userLikeFeedPhotosCollection = $this->userSettingRepository->fetchUserLikeFeedPhotos($userId);
        
        // check if user photos exists
        if (!__isEmpty($userPhotosCollection)) {
            foreach ($userLikeFeedPhotosCollection as $userPhoto) {
                $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
                $likePhotosdata[] = [
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
                    'is_like'   => $userPhoto->is_like,
                    'is_tagged' => $userPhoto->is_tagged
                ];
            }
        }

        $taggedPhotosdata = [];
        // Get user photos collection
        $userTaggedFeedPhotosCollection = $this->userSettingRepository->fetchUserTaggedFeedPhotos($userId);
        
        // check if user photos exists
        if (!__isEmpty($userTaggedFeedPhotosCollection)) {
            foreach ($userTaggedFeedPhotosCollection as $userPhoto) {
                $userPhotosFolderPath = getPathByKey('user_photos', ['{_uid}' => $userPhoto->userUId]);
                $taggedPhotosdata[] = [
                    'image_url' => getMediaUrl($userPhotosFolderPath, $userPhoto->photo_image),
                ];
            }
        }

        //fetch total visitors data
        $visitorData = $this->userRepository->fetchProfileVisitor($userId);

        //fetch user gift record
        $userGiftCollection = $this->userRepository->fetchUserGift($userId);

        $userGiftData = [];
        //check if not empty
        if (!__isEmpty($userGiftCollection)) {
            foreach ($userGiftCollection as $key => $userGift) {
                $userGiftImgUrl = '';
                $userGiftFolderPath = getPathByKey('gift_image', ['{_uid}' => $userGift->itemUId]);
                $userGiftImgUrl = getMediaUrl($userGiftFolderPath, $userGift->file_name);
                //check gift status is private (1) and check gift send to current user or gift send by current user
                if ($userGift->status == 1 and ($userGift->to_users__id == getUserID() || $userGift->from_users__id == getUserID())) {
                    if (__isEmpty($userGift->file_name)) {
                        $userGiftImgUrl = noThumbImageURL();
                    }

                    $userGiftData[] = [
                        '_id' => $userGift->_id,
                        '_uid' => $userGift->_uid,
                        'itemId' => $userGift->itemId,
                        'status' => $userGift->status,
                        'fromUserName' => $userGift->fromUserName,
                        'senderUserName' => $userGift->senderUserName,
                        'userGiftImgUrl' => $userGiftImgUrl,
                    ];
                //check gift status is public (0)
                } elseif ($userGift->status != 1) {
                    if (__isEmpty($userGift->file_name)) {
                        $userGiftImgUrl = noThumbImageURL();
                    }

                    $userGiftData[] = [
                        '_id' => $userGift->_id,
                        '_uid' => $userGift->_uid,
                        'itemId' => $userGift->itemId,
                        'status' => $userGift->status,
                        'fromUserName' => $userGift->fromUserName,
                        'senderUserName' => $userGift->senderUserName,
                        'userGiftImgUrl' => $userGiftImgUrl,
                    ];
                }
            }
        }

        //fetch gift collection
        $giftCollection = $this->manageItemRepository->fetchListData(1);

        $giftListData = [];
        if (!__isEmpty($giftCollection)) {
            foreach ($giftCollection as $key => $giftData) {
                //only active gifts
                if ($giftData->status == 1) {
                    $giftImageUrl = '';
                    $giftImageFolderPath = getPathByKey('gift_image', ['{_uid}' => $giftData->_uid]);
                    $giftImageUrl = getMediaUrl($giftImageFolderPath, $giftData->file_name);
                    //get normal price or normal price is zero then show free gift
                    $normalPrice = (isset($giftData['normal_price']) and intval($giftData['normal_price']) <= 0) ? 'Free' : intval($giftData['normal_price']).' '.__tr('credits');

                    //get premium price or premium price is zero then show free gift
                    $premiumPrice = (isset($giftData['premium_price']) and $giftData['premium_price'] <= 0) ? 'Free' : $giftData['premium_price'].' '.__tr('credits');
                    $giftData['premium_price'].' '.__tr('credits');

                    $price = 'Free';
                    //check user is premium or normal or Set price
                    if (isPremiumUser()) {
                        $price = $premiumPrice;
                    } else {
                        $price = $normalPrice;
                    }
                    $giftListData[] = [
                        '_id' => $giftData['_id'],
                        '_uid' => $giftData['_uid'],
                        'normal_price' => $normalPrice,
                        'premium_price' => $giftData['premium_price'],
                        'formattedPrice' => $price,
                        'gift_image_url' => $giftImageUrl,
                    ];
                }
            }
        }

        $specificationCollection = $this->userSettingRepository->fetchUserSpecificationById($userId);
        // Check if user specifications exists
        if (!\__isEmpty($specificationCollection)) {
            $userSpecifications = $specificationCollection->pluck('specification_value', 'specification_key')->toArray();
        }
        $specificationConfig = $this->getUserSpecificationConfig();
        foreach ($specificationConfig['groups'] as $specKey => $specification) {
            $items = [];
            foreach ($specification['items'] as $itemKey => $item) {
                $itemValue = '';
                $userSpecValue = isset($userSpecifications[$itemKey])
                    ? $userSpecifications[$itemKey]
                    : '';
                if (!__isEmpty($userSpecValue)) {
                    $itemValue = isset($item['options'])
                        ? (isset($item['options'][$userSpecValue])
                            ? $item['options'][$userSpecValue] : '')
                        : $userSpecValue;
                }
                $items[] = [
                    'label' => $item['name'],
                    'value' => $itemValue,
                ];
            }

            // Check if Item exists
            if (!__isEmpty($items)) {
                $userSpecificationData[$specKey] = [
                    'title' => $specification['title'],
                    'items' => $items,
                ];
            }
        }

        //fetch block me users
        $blockMeUser = $this->userRepository->fetchBlockMeUser($user->_id);
        $isBlockUser = false;
        //check if not empty then set variable is true
        if (!__isEmpty($blockMeUser)) {
            $isBlockUser = true;
        }

        //fetch block by me user
        $blockUserData = $this->userRepository->fetchBlockUser($user->_id);
        $blockByMe = false;
        //if it is empty
        if (!__isEmpty($blockUserData)) {
            $blockByMe = true;
        }

        //fetch like dislike data by to user id
        $likeDislikeData = $this->userRepository->fetchLikeDislike($user->_id);

        $userLikeData = [];
        //check is not empty
        if (!__isEmpty($likeDislikeData)) {
            $userLikeData = [
                '_id' => $likeDislikeData->_id,
                'like' => $likeDislikeData->like,
            ];
        }

        //fetch like dislike data by to user id
        $userGymsData = $this->userRepository->fetchUserGymData($user->_id);

        return $this->engineReaction(1, [
            'userData' => $userData,
            'userProfileData' => $userProfileData,
            'photosData' => $photosData,
            'totalUserLike' => fetchTotalUserLikedCount($userId),
            'totalUserCredits' => totalUserCredits(),
            'totalVisitors' => $visitorData->count(),
            'userGiftData' => $userGiftData,
            'isPremiumUser' => isPremiumUser($userId),
            'isOwnProfile' => ($userId == getUserID()) ? true : false,
            'specifications' => (array) $userSpecificationData,
            'isBlockUser' => $isBlockUser,
            'blockByMeUser' => $blockByMe,
            'giftListData' => $giftListData,
            'userLikeData' => $userLikeData,
            'userGymData'  => $userGymData,
            'likePhotosData' => $likePhotosdata,
            'taggedPhotosdata'   => $taggedPhotosdata

        ]);
    }

    /**
     * Process reset password request.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function changeEmailProcess($input)
    {
        $email = $input['current_email'];

        //fetch active user by email
        $user = $this->userRepository->fetchActiveUserByEmail($email);

        // Check if user record exist
        if (__isEmpty($user)) {
            return  $this->engineReaction(18, ['show_message' => true], __tr('Invalid Request.'));
        }

        // Check if user entered correct password or not
        if (!Hash::check($input['current_password'], $user->password)) {
            return $this->engineReaction(3, [], __tr('Authentication Failed. Please Check Your Password.'));
        }

        // Check if user password updated
        if ($this->userRepository->updateUser($user, ['email' => $input['new_email']])) {
            return  $this->engineReaction(1, [
                'show_message' => true,
            ], __tr('Email updated successfully.'));
        }

        //failed response
        return  $this->engineReaction(2, ['show_message' => true], __tr('Email not updated.'));
    }

    /**
     * prepare profile details.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareProfileUpdate()
    {
        $user = $this->userRepository->fetchByID(getUserID());

        // Check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(18, ['show_message' => true], __tr('User does not exists.'));
        }

        $userId = $user->_id;
        $userUid = $user->_uid;

        $basicInformation = $userSpecifications = $userSpecificationData = $locationInformation = [];

        // fetch User details
        $userProfile = $this->userSettingRepository->fetchUserProfile($userId);

        $profilePictureUrl = noThumbImageURL();
        $coverPictureUrl = noThumbCoverImageURL();
        $userSettingConfig = configItem('user_settings');
        $profilePictureFolderPath = getPathByKey('profile_photo', ['{_uid}' => $userUid]);
        $coverPictureFolderPath = getPathByKey('cover_photo', ['{_uid}' => $userUid]);

        // Check if user profile exists
        if (!__isEmpty($userProfile)) {
            if (!__isEmpty($userProfile->profile_picture)) {
                $profilePictureUrl = getMediaUrl($profilePictureFolderPath, $userProfile->profile_picture);
            }
            if (!__isEmpty($userProfile->cover_picture)) {
                $coverPictureUrl = getMediaUrl($coverPictureFolderPath, $userProfile->cover_picture);
            }
        }

        $dob = isset($userProfile['dob']) ? formatDate($userProfile['dob'], 'Y-m-d') : null;

        // Prepare user data
        $basicInformation = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'mobile_number' => $user->mobile_number,
            'work_status' => (string) isset($userProfile['work_status']) ? $userProfile['work_status'] : null,
            'gender' => (string) isset($userProfile['gender']) ? $userProfile['gender'] : null,
            'relationship_status' => (string) isset($userProfile['relationship_status']) ? $userProfile['relationship_status'] : null,
            'preferred_language' => (string) isset($userProfile['preferred_language']) ? $userProfile['preferred_language'] : null,
            'education' => (string) isset($userProfile['education']) ? $userProfile['education'] : null,
            'birthday' => $dob,
            'about_me' => isset($userProfile['about_me']) ? $userProfile['about_me'] : null,
            'country' => isset($userProfile['countries__id']) ? $userProfile['countries__id'] : null,
            'profile_picture' => $profilePictureUrl,
            'cover_picture' => $coverPictureUrl,
            'profileMediaRestriction' => getMediaRestriction('profile'),
            'coverImageMediaRestriction' => getMediaRestriction('cover_image'),
        ];

        // Prepare user data
        $locationInformation = [
            'country' => isset($userProfile['countries__id']) ? $userProfile['countries__id'] : null,
            'location_latitude' => isset($userProfile['location_latitude']) ? floatval($userProfile['location_latitude']) : null,
            'location_longitude' => isset($userProfile['location_longitude']) ? floatval($userProfile['location_longitude']) : null,
        ];

        $specificationCollection = $this->userSettingRepository->fetchUserSpecificationById($userId);

        // Check if user specifications exists
        if (!__isEmpty($specificationCollection)) {
            $userSpecifications = $specificationCollection->pluck('specification_value', 'specification_key')->toArray();
        }

        $specificationConfig = $this->getUserSpecificationConfig();

        foreach ($specificationConfig['groups'] as $specKey => $specification) {
            $items = [];

            foreach ($specification['items'] as $itemKey => $item) {
                $itemValue = '';
                $userSpecValue = isset($userSpecifications[$itemKey])
                    ? $userSpecifications[$itemKey]
                    : '';
                if (!__isEmpty($userSpecValue)) {
                    $itemValue = isset($item['options'])
                        ? (isset($item['options'][$userSpecValue])
                            ? $item['options'][$userSpecValue] : '')
                        : $userSpecValue;
                }

                $items[] = [
                    'name' => $itemKey,
                    'label' => $item['name'],
                    'value' => $itemValue,
                    'options' => isset($item['options']) ? $item['options'] : '',
                    'selected_options' => $userSpecValue,
                ];
            }

            // Check if Item exists
            if (!__isEmpty($items)) {
                $userSpecificationData[$specKey] = [
                    'title' => $specification['title'],
                    'items' => $items,
                ];
            }
        }

        $allGenders = configItem('user_settings.gender');

        $genders = [];

        foreach ($allGenders as $key => $value) {
            $genders[] = [
                'id' => $key,
                'value' => $value,
            ];
        }

        return $this->engineReaction(1, [
            'basicInformation' => $basicInformation,
            'locationInformation' => $locationInformation,
            'specifications' => (array) $userSpecificationData,
            'countries' => $this->countryRepository->fetchAll()->toArray(),
            'user_settings' => configItem('user_settings'),
        ]);
    }

    /**
     * prepare featured users.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function prepareFeaturedUsers()
    {
        return $this->engineReaction(1, [
            'getFeatureUserList' => getFeatureUserList(),
        ]);
    }

    
    public function preparePromotionPlanStripeUserData()
    {
        // Subscription plan data
        $promotionPlanCollection = getStoreSettings('promotion_plan_duration');
        $promotionPlans = $promotionPlanData = [];

        // check if user premium plan exists
        if (!__isEmpty($promotionPlanCollection)) {
            $promotionPlans = is_array($promotionPlanCollection) ? $promotionPlanCollection : json_decode($promotionPlanCollection, true);
            $planDurationConfig = config('__settings.items.promotion-plans');
            $defaultPlanDuration = $planDurationConfig['promotion_plan_duration']['default'];
            $promotionPlanData = combineArray($defaultPlanDuration, $promotionPlans);
        }

        $userSubscription = $this->userSettingRepository->fetchUserSubscriptionStripeSponser(getUserID());

        $userSubscriptionData = [];
        if (!__isEmpty($userSubscription) and !__isEmpty($promotionPlans) and !__isEmpty($promotionPlanData)) {

            $next_payment_date = "";
            $card_type = "";
            $card_last4 = "";
            $card_icon = "credit-card";
            try {
                Stripe::setApiKey('sk_test_b2wZzWjywE2nfKqNAPQBd11S00iBKRMQ2r'); 
                
                $customer = \Stripe\Customer::retrieve($userSubscription->stripe_customer_id);
                $subscription = $customer->subscriptions->retrieve($userSubscription->stripe_subscription_id);
                $next_payment_date = Carbon::parse($subscription->current_period_end)->format('j F Y');
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
                
            }
            catch(\Stripe\Exception\InvalidRequestException $e){
                
        
            } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            } catch (\Stripe\Exception\ApiErrorException $e) {

            } catch (\Stripe\Error\Base $e) {
                // Code to do something with the $e exception object when an error occurs
                echo($e->getMessage());
            } catch (Exception $e) {
            // Catch any other non-Stripe exceptions
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
                'card_type'         => $card_type,
                'card_last4'        => $card_last4,
                'card_icon'         => $card_icon,
                'user_pricing_id'        => $userSubscription->user_pricing_id,
                'pricing_value'         => $userSubscription->price,
                'pricing_session'       => $userSubscription->session
            ];
        }
        
        return $this->engineReaction(1, [
            'promotionPlanData' => [
                'isPromotionSponserUserStripe'         => isPromotionSponserUserStripe(),
                'userSubscriptionData'     => $userSubscriptionData,
                'promotionPlans'           => $promotionPlanData
            ]
        ]);
    }

}
