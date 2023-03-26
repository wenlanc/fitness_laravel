<?php
/**
* UserSettingController.php - Controller file.
*
* This file is part of the UserSetting component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\UserSetting\Controllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\UserSetting\Requests\UserBasicSettingAddRequest;
use App\Yantrana\Components\UserSetting\Requests\UserProfileSettingAddRequest;
use App\Yantrana\Components\UserSetting\Requests\UserProfileWizardRequest;
use App\Yantrana\Components\UserSetting\Requests\UserSettingRequest;
use App\Yantrana\Components\UserSetting\Requests\UserSettingAccountEditRequest;
use App\Yantrana\Components\UserSetting\Requests\UserSettingPrivacyEditRequest;
use App\Yantrana\Components\UserSetting\UserSettingEngine;
use App\Yantrana\Components\User\PremiumPlanEngine;
use App\Yantrana\Support\CommonUnsecuredPostRequest;
use Illuminate\Http\Request;

class UserSettingController extends BaseController
{
    /**
     * @var UserSettingEngine - UserSetting Engine
     */
    protected $userSettingEngine;

    protected $premiumPlanEngine;
    /**
     * Constructor.
     *
     * @param UserSettingEngine $userSettingEngine - UserSetting Engine
     *
     * @return void
     *-----------------------------------------------------------------------*/
    public function __construct(UserSettingEngine $userSettingEngine, PremiumPlanEngine $premiumPlanEngine)
    {
        $this->userSettingEngine = $userSettingEngine;
        $this->premiumPlanEngine = $premiumPlanEngine;
    }

    /**
     * Show user setting view.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function getUserSettingView($pageType)
    {
        $processReaction = [];
        if($pageType == 'billing'){
            $processReaction = $this->userSettingEngine->preparePremiumPlanStripeUserData();
        } else if($pageType == 'account') {
            $processReaction = $this->userSettingEngine->prepareSettingAccountData();
        } else {
            $processReaction = $this->userSettingEngine->prepareUserSettings($pageType);
        }
        abort_if($processReaction['reaction_code'] == 18, 404, $processReaction['message']);
        return $this->loadPublicView('user.settings.settings', $processReaction['data']);
    }

    /**
     * Get UserSetting Data.
     *
     * @param string $pageType
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreUserSetting(UserSettingRequest $request, $pageType)
    {
        $processReaction = $this->userSettingEngine
            ->processUserSettingStore($pageType, $request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Process store user basic settings.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUserBasicSetting(UserBasicSettingAddRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreUserBasicSettings($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processUserAvailability(Request $request)
    {
        $processReaction = $this->userSettingEngine->processStoreUserAvailability($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Process profile Update Wizard.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function profileUpdateWizard(UserProfileWizardRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreProfileWizard($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Process store user basic settings.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processLocationData(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreLocationData($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processExpertiseData(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreExpertiseData($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processStoreSessionData(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreSessionData($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processRemoveSessionData(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processDeleteUserPricing($request->all());
        return $this->processResponse($processReaction, [], [], true);
    }


    /**
     * Process upload profile image.
     *
     * @param object CommonUnsecuredPostRequest $request
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function uploadProfileImage(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processUploadProfileImage($request->all(), 'profile');

        return $this->processResponse($processReaction, [], [], true);
    }

    public function uploadProfileImageBlob(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processUploadProfileImageBlob($request->all(), 'profile');

        return $this->processResponse($processReaction, [], [], true);
    }

    /**
     * Process upload cover image.
     *
     * @param object CommonUnsecuredPostRequest $request
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function uploadCoverImage(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processUploadCoverImage($request->all(), 'cover_image');

        return $this->processResponse($processReaction, [], [], true);
    }

    /**
     * Process user profile settings.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUserProfileSetting(UserProfileSettingAddRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreUserProfileSetting($request->all());

        return $this->processResponse($processReaction, [], [], true);
    }

    /**
     * Show user photos view.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function getUserPhotosSetting()
    {
        $processReaction = $this->userSettingEngine->prepareUserPhotosSettings();

        return $this->loadPublicView('user.settings.photos', $processReaction['data']);
    }

    /**
     * Upload multiple photos.
     *
     * @param object CommonUnsecuredPostRequest $request
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function uploadPhotos(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processUploadPhotos($request->all());

        return $this->processResponse($processReaction, [], [], true);
    }

    /**
     * Upload multiple photos.
     *
     * @param object CommonUnsecuredPostRequest $request
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function deleteUserPhotos($photoUid)
    {
        $processReaction = $this->userSettingEngine->processDeleteUserPhotos($photoUid);

        return $this->processResponse($processReaction, [], [], true);
    }
    public function likeUserPhotos($photoUid)
    {
        $processReaction = $this->userSettingEngine->processLikeUserPhotos($photoUid);

        return $this->processResponse($processReaction, [], [], true);
    }
    public function taggedUserPhotos($photoUid)
    {
        $processReaction = $this->userSettingEngine->processTaggedUserPhotos($photoUid);

        return $this->processResponse($processReaction, [], [], true);
    }
    public function editUserPhotos(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processEditUserPhotos($request->all());

        return $this->processResponse($processReaction, [], [], true);
    }

    public function likeUserFeed($photoUid)
    {
        $processReaction = $this->userSettingEngine->processLikeUserFeed($photoUid);

        return $this->processResponse($processReaction, [], [], true);
    }
    public function taggedUserFeed($photoUid)
    {
        $processReaction = $this->userSettingEngine->processTaggedUserFeed($photoUid);

        return $this->processResponse($processReaction, [], [], true);
    }
    public function editUserFeed(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processEditUserFeed($request->all());

        return $this->processResponse($processReaction, [], [], true);
    }
    public function commentUserFeed(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processCommentUserFeed($request->all());

        return $this->processResponse($processReaction, [], [], true);
    }
    
    /**
     * Search Cities.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function searchStaticCities(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->searchStaticCities($request->get('search_query'));

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Search Cities.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function searchStaticGym(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->searchStaticGym($request->get('search_query'));

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Process store user city.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processStoreCity(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->userSettingEngine->processStoreCity($request->get('selected_city_id'));

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    /**
     * Process setting account.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processSettingAccount(UserSettingAccountEditRequest $request)
    {
        $processReaction = $this->userSettingEngine->processSettingAccount($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingPrivacy(UserSettingPrivacyEditRequest $request)
    {
        $processReaction = $this->userSettingEngine->processSettingPrivacy($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }


    /**
     * Process user setting account.
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function processUserSettingAccount(CommonUnsecuredPostRequest $request)
    {
        //$processReaction = $this->userSettingEngine->processStoreLocationData($request->all());

        $processReaction = $this->userSettingEngine->processUserSettingAccount($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingSubscription(CommonUnsecuredPostRequest $request) {
        $processReaction = $this->userSettingEngine->processUserSubscription($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingCancelSubscription() {
        $processReaction = $this->userSettingEngine->processUserCancelSubscription();

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingUpdateCardSubscription(CommonUnsecuredPostRequest $request) {
        $processReaction = $this->userSettingEngine->processUserSubscriptionUpdateCard($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingDowngradeSubscription() {
        $processReaction = $this->userSettingEngine->processUserSubscriptionDowngrade();

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingUpgradeSubscription() {
        $processReaction = $this->userSettingEngine->processUserSubscriptionUpgrade();

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingSubscriptionSponser(CommonUnsecuredPostRequest $request) {
        $processReaction = $this->userSettingEngine->processUserSubscriptionSponser($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingCancelSubscriptionSponser() {
        $processReaction = $this->userSettingEngine->processUserCancelSubscriptionSponser();

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }

    public function processSettingUpdateCardSubscriptionSponser(CommonUnsecuredPostRequest $request) {
        $processReaction = $this->userSettingEngine->processUserSubscriptionUpdateCardSponser($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
    
}
