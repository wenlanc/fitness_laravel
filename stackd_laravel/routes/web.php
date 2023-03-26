<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Lw-Dating Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'namespace' => '\App\Yantrana\Components',
    'middleware' => 'common.entrance',
], function () {
    Route::get('/change-language/{localeID}', [
        'as' => 'locale.change',
        'uses' => 'Home\Controllers\HomeController@changeLocale',
    ]);

    // contact view
    Route::get('/contact', [
        'as' => 'user.read.contact',
        'uses' => 'User\Controllers\UserController@getContactView',
    ]);

    // process contact form
    Route::post('/post-contact', [
        'as' => 'user.contact.process',
        'uses' => 'User\Controllers\UserController@contactProcess',
    ]);

    // page preview
    Route::get('/page/{pageUId}/{title}', [
        'as' => 'page.preview',
        'uses' => 'Home\Controllers\HomeController@previewPage',
    ]);

    /*
    User Components Public Section Related Routes
    ----------------------------------------------------------------------- */
    Route::group(['middleware' => 'guest'], function () {
        Route::group([
            'namespace' => 'Home\Controllers',
        ], function () {
            // Get landing page view
            Route::get('/', [
                'as' => 'landing_page',
                'uses' => 'HomeController@landingPage',
            ]);
            // Get landing page view
            Route::get('/about_page', [
                'as' => 'about_page',
                'uses' => 'HomeController@aboutPage',
            ]);
            // Process search from landing page
            Route::post('/search-matches', [
                'as' => 'search_matches',
                'uses' => 'HomeController@searchMatches',
            ]);
        });

        Route::group([
            'namespace' => 'User\Controllers',
            'prefix' => 'user',
        ], function () {
            // login
            Route::get('/login', [
                'as' => 'user.login',
                'uses' => 'UserController@login',
            ]);

            // login process
            Route::post('/login-process', [
                'as' => 'user.login.process',
                'uses' => 'UserController@loginProcess',
            ]);

            // User Registration
            Route::get('/sign-up', [
                'as' => 'user.sign_up',
                'uses' => 'UserController@signUp',
            ]);

            // User Registration Process
            Route::post('/sign-up-process', [
                'as' => 'user.sign_up.process',
                'uses' => 'UserController@signUpProcess',
            ]);

            // forgot password view
            Route::get('/forgot-password', [
                'as' => 'user.forgot_password',
                'uses' => 'UserController@forgotPasswordView',
            ]);

            // forgot password process
            Route::post('/forgot-password-process', [
                'as' => 'user.forgot_password.process',
                'uses' => 'UserController@processForgotPassword',
            ]);

            // reset password
            Route::get('/reset-password', [
                'as' => 'user.reset_password',
                'uses' => 'UserController@restPasswordView',
            ]);

            // reset password process
            Route::post('/reset-password-process/{reminderToken}', [
                'as' => 'user.reset_password.process',
                'uses' => 'UserController@processRestPassword',
            ]);

            // Account Activation
            Route::get('/{userUid}/account-activation', [
                'as' => 'user.account.activation',
                'uses' => 'UserController@accountActivation',
            ])->middleware('signed');
        });

        Route::group([
            'namespace' => 'UserSetting\Controllers',
            'prefix' => 'settings',
        ], function () {
            Route::post('/search-static-cities', [
                'as' => 'user.read.search_static_cities',
                'uses' => 'UserSettingController@searchStaticCities',
            ]);
            Route::post('/search-static-gym', [
                'as' => 'user.read.search_static_gym',
                'uses' => 'UserSettingController@searchStaticGym',
            ]);
            Route::post('/search-static-expertise', [
                'as' => 'user.read.search_static_expertise',
                'uses' => 'UserSettingController@searchStaticExpertise',
            ]);
        });
    });

    /*
    User Social Access Components Public Section Related Routes
    ----------------------------------------------------------------------- */
    Route::group([
        'namespace' => 'User\Controllers',
        'prefix' => 'user/social-login',
    ], function () {
        // social user login
        Route::get('/request/{provider}', [
            'as' => 'social.user.login',
            'uses' => 'SocialAccessController@redirectToProvider',
        ]);

        // social user login callback
        Route::get('/response/{provider}', [
            'as' => 'social.user.login.callback',
            'uses' => 'SocialAccessController@handleProviderCallback',
        ]);
    });

    /*
    After Authentication Accessible Routes
    -------------------------------------------------------------------------- */

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/change-theme/{themeName}', [
            'as' => 'site_theme.change',
            'uses' => 'Home\Controllers\HomeController@changeTheme',
        ]);

        // Home page for logged in user
        Route::get('/home', [
            'as' => 'home_page',
            'uses' => 'Home\Controllers\HomeController@homePage',
        ]);

        // Get User Profile view
        Route::get('/@{username}', [
            'as' => 'user.profile_view',
            'uses' => 'User\Controllers\UserController@getUserProfile',
        ]);
        // Get user profile data
        Route::get('/get-user-profile-data', [
            'as' => 'user.get_profile_data',
            'uses' => 'User\Controllers\UserController@getUserProfileData',
        ]);
        // View photos settings
        Route::get('/@{username}/photos', [
            'as' => 'user.photos_setting',
            'uses' => 'UserSetting\Controllers\UserSettingController@getUserPhotosSetting',
        ]);

        // User Photo Data : User photo, tagged , favourite
        Route::get('/@{username}/photos-data', [
            'as' => 'user.read.photos_data',
            'uses' => 'User\Controllers\UserController@getUserPhotoData',
        ]);
        Route::get('/@{username}/photos-tagged-data', [
            'as' => 'user.read.photos_tagged_data',
            'uses' => 'User\Controllers\UserController@getUserPhotoTaggedData',
        ]);
        Route::get('/@{username}/photos-favourite-data', [
            'as' => 'user.read.photos_favourite_data',
            'uses' => 'User\Controllers\UserController@getUserPhotoFavouriteData',
        ]);

        Route::get('/@{username}/feeds', [
            'as' => 'user.read.list_feed',
            'uses' => 'User\Controllers\UserController@getUserFeeds',
        ]);

        Route::get('/pt/@{username}', [
            'as' => 'user.pt_profile_view',
            'uses' => 'User\Controllers\UserController@getPtProfile',
        ]);
        /*
        Filter Components Public Section Related Routes
        ----------------------------------------------------------------------- */
        Route::group([
            'namespace' => 'Filter\Controllers',
        ], function () {
            // Show Find Matches View
            Route::get('/find-matches', [
                'as' => 'user.read.find_matches',
                'uses' => 'FilterController@getFindMatches',
            ]);
            Route::get('/find-pt', [
                'as' => 'user.read.find_pt',
                'uses' => 'FilterController@getFindPT',
            ]);
            Route::get('/match_list', [
                'as' => 'user.read.match_list',
                'uses' => 'FilterController@getMatchesList',
            ]);
            Route::get('/blocked_list', [
                'as' => 'user.read.blocked_list',
                'uses' => 'FilterController@getBlockedList',
            ]);
            Route::get('/pt_list', [
                'as' => 'user.read.pt_list',
                'uses' => 'FilterController@getPtList',
            ]);
            Route::get('/pending_list', [
                'as' => 'user.read.pending_list',
                'uses' => 'FilterController@getPendingList',
            ]);
            Route::get('/visitor_list', [
                'as' => 'user.read.visitor_list',
                'uses' => 'FilterController@getVisitorList',
            ]);
        });

        /*
         * User Section
        ----------------------------------------------------------------------- */
        Route::group([
            'prefix' => 'user',
        ], function () {
            /*
            User Component Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
            ], function () {

                // Get user profile data
                Route::get('/update-profile-wizard', [
                    'as' => 'user.update_profile.wizard',
                    'uses' => 'UserController@loadProfileUpdateWizard',
                ]);

                // Get user profile data
                Route::get('/check-profile-updated', [
                    'as' => 'user.profile.wizard_completed',
                    'uses' => 'UserController@checkProfileUpdateWizard',
                ]);

                // Get user profile data
                Route::post('/finish-wizard', [
                    'as' => 'user.profile.finish_wizard',
                    'uses' => 'UserController@finishWizard',
                ]);

                // User Registration Process
                Route::post('/sign-up-profile-process', [
                    'as' => 'user.sign_up_profile.process',
                    'uses' => 'UserController@signUpProfileProcess',
                ]);

                Route::post('/sign-up-availability-process', [
                    'as' => 'user.sign_up_availability.process',
                    'uses' => 'UserController@signUpAvailabilityProcess',
                ]);

                Route::post('/sign-up-location-process', [
                    'as' => 'user.sign_up_location.process',
                    'uses' => 'UserController@signUpLocationProcess',
                ]);
                
                // logout
                Route::get('/logout', [
                    'as' => 'user.logout',
                    'uses' => 'UserController@logout',
                ]);

                // change password view
                Route::get('/change-password', [
                    'as' => 'user.change_password',
                    'uses' => 'UserController@changePasswordView',
                ]);

                // User Change Password Process
                Route::post('/change-password-process', [
                    'as' => 'user.change_password.process',
                    'uses' => 'UserController@processChangePassword',
                ]);

                // change email view
                Route::get('/change-email', [
                    'as' => 'user.change_email',
                    'uses' => 'UserController@changeEmailView',
                ]);

                // User Change Email Process
                Route::post('/change-email-process', [
                    'as' => 'user.change_email.process',
                    'uses' => 'UserController@processChangeEmail',
                ]);

                // New Email Activation
                Route::get('/{userUid}/{newEmail}/new-email-activation', [
                    'as' => 'user.new_email.activation',
                    'uses' => 'UserController@newEmailActivation',
                ]);

                // Get User Profile view
                Route::get('/update-email-success', [
                    'as' => 'user.new_email.read.success',
                    'uses' => 'UserController@updateEmailSuccessView',
                ]);

                // User Like Dislike route
                Route::post('/{toUserUid}/{like}/user-like-dislike', [
                    'as' => 'user.write.like_dislike',
                    'uses' => 'UserController@userLikeDislike',
                ]);

                Route::post('/{toUserUid}/user-remove-like-dislike', [
                    'as' => 'user.write.remove_like_dislike',
                    'uses' => 'UserController@userRemoveLikeDislike',
                ]);

                Route::post('/{toUserUid}/user-hide-like-dislike', [
                    'as' => 'user.write.hide_like_dislike',
                    'uses' => 'UserController@userHideLiked',
                ]);

                // Get User My like view
                Route::get('/liked', [
                    'as' => 'user.my_liked_view',
                    'uses' => 'UserController@getMyLikeView',
                ]);

                // Get User My Dislike view
                Route::get('/disliked', [
                    'as' => 'user.my_disliked_view',
                    'uses' => 'UserController@getMyDislikedView',
                ]);

                // Get who liked me users
                Route::get('/who-liked-me', [
                    'as' => 'user.who_liked_me_view',
                    'uses' => 'UserController@getWhoLikedMeView',
                ]);

                // Get mutual likes users
                Route::get('/mutual-likes', [
                    'as' => 'user.mutual_like_view',
                    'uses' => 'UserController@getMutualLikeView',
                ]);

                Route::get('/follows-list', [
                    'as' => 'user.read.get_follows',
                    'uses' => 'UserController@getFollowUserList',
                ]);

                Route::get('/followers-list', [
                    'as' => 'user.read.get_followers',
                    'uses' => 'UserController@getFollowersList',
                ]);

                Route::get('/followings-list', [
                    'as' => 'user.read.get_followings',
                    'uses' => 'UserController@getFollowingsList',
                ]);

                // Post user support
                Route::post('/request_support', [
                    'as' => 'user.write.request_support',
                    'uses' => 'UserController@userRequestSupport',
                ]);

                // Get profile visitors users
                Route::get('/visitors', [
                    'as' => 'user.profile_visitors_view',
                    'uses' => 'UserController@getProfileVisitorView',
                ]);

                // post User send gift
                Route::post('/{sendUserUId}/send-gift', [
                    'as' => 'user.write.send_gift',
                    'uses' => 'UserController@userSendGift',
                ]);

                // post User photo
                Route::post('/post-photo', [
                    'as' => 'user.write.post_photo',
                    'uses' => 'UserController@userPostPhoto',
                ]);

                Route::get('/{photoUId}/get-photo-info', [
                    'as' => 'user.read.photo_info',
                    'uses' => 'UserController@userGetPhotoInfo',
                ]);
                
                // post User review
                Route::post('/{sendUserUId}/post-review', [
                    'as' => 'user.write.post_review',
                    'uses' => 'UserController@userPostReview',
                ]);


                // post report user
                Route::post('/report-user', [
                    'as' => 'user.write.report_user',
                    'uses' => 'UserController@reportUser',
                ]);

                // post User send block-user
                Route::post('/block-user', [
                    'as' => 'user.write.block_user',
                    'uses' => 'UserController@blockUser',
                ]);

                // block user list
                Route::get('/blocked-users', [
                    'as' => 'user.read.block_user_list',
                    'uses' => 'UserController@blockUserList',
                ]);

                // post un-block user
                Route::post('/unblock-user', [
                    'as' => 'user.write.unblock_user',
                    'uses' => 'UserController@unblockUser',
                ]);

                // post un-block user
                Route::post('/boost-profile', [
                    'as' => 'user.write.boost_profile',
                    'uses' => 'UserController@processBoostProfile',
                ]);

                // block user list
                Route::get('/get-booster-info', [
                    'as' => 'user.read.booster_data',
                    'uses' => 'UserController@getBoosterInfo',
                ]);

                // Permanent delete account
                Route::post('/delete-account', [
                    'as' => 'user.write.delete_account',
                    'uses' => 'UserController@deleteAccount',
                ]);

                Route::get('/get-sponser-ad', [
                    'as' => 'user.read.sponser-ad',
                    'uses' => 'UserController@getSponserAd',
                ]);
                

            });

            // User Settings related routes
            Route::group([
                'namespace' => 'UserSetting\Controllers',
                'prefix' => 'settings',
            ], function () {
                // View settings
                Route::get('/{pageType}', [
                    'as' => 'user.read.setting',
                    'uses' => 'UserSettingController@getUserSettingView',
                ]);
                // Process Configuration Data
                Route::post('/{pageType}/process-user-setting-store', [
                    'as' => 'user.write.setting',
                    'uses' => 'UserSettingController@processStoreUserSetting',
                ]);
                // Process basic settings
                Route::post('/process-basic-settings', [
                    'as' => 'user.write.basic_setting',
                    'uses' => 'UserSettingController@processUserBasicSetting',
                ]);

                // Process basic settings
                Route::post('/process-availability', [
                    'as' => 'user.write.availability',
                    'uses' => 'UserSettingController@processUserAvailability',
                ]);

                // Process basic settings
                Route::post('/process-update-profile-wizard', [
                    'as' => 'user.write.update_profile_wizard',
                    'uses' => 'UserSettingController@profileUpdateWizard',
                ]);

                // Process location / maps data
                // Route::post('/search-static-cities', [
                //     'as' => 'user.read.search_static_cities',
                //     'uses' => 'UserSettingController@searchStaticCities',
                // ]);

                // Process location / maps data
                Route::post('/store-city', [
                    'as' => 'user.write.store_city',
                    'uses' => 'UserSettingController@processStoreCity',
                ]);

                // Process location / maps data
                Route::post('/process-location-data', [
                    'as' => 'user.write.location_data',
                    'uses' => 'UserSettingController@processLocationData',
                ]);
                // Store User Profile Image
                Route::post('/upload-profile-image', [
                    'as' => 'user.upload_profile_image',
                    'uses' => 'UserSettingController@uploadProfileImage',
                ]);
                Route::post('/upload-profile-imageblob', [
                    'as' => 'user.upload_profile_imageblob',
                    'uses' => 'UserSettingController@uploadProfileImageBlob',
                ]);
                // Store User Cover Image
                Route::post('/upload-cover-image', [
                    'as' => 'user.upload_cover_image',
                    'uses' => 'UserSettingController@uploadCoverImage',
                ]);
                // Process User Profile
                Route::post('/process-profile-setting', [
                    'as' => 'user.write.profile_setting',
                    'uses' => 'UserSettingController@processUserProfileSetting',
                ]);
                // Upload multiple hotos
                Route::post('/upload-photos', [
                    'as' => 'user.upload_photos',
                    'uses' => 'UserSettingController@uploadPhotos',
                ]);
                // delete photo
                Route::post('/{photoUid}/delete-photos', [
                    'as' => 'user.upload_photos.write.delete',
                    'uses' => 'UserSettingController@deleteUserPhotos',
                ]);
                // Like photo
                Route::post('/{photoUid}/like-photos', [
                    'as' => 'user.upload_photos.write.like',
                    'uses' => 'UserSettingController@likeUserPhotos',
                ]);
                // Tagged photo
                Route::post('/{photoUid}/tagged-photos', [
                    'as' => 'user.upload_photos.write.tagged',
                    'uses' => 'UserSettingController@taggedUserPhotos',
                ]);
                Route::post('/edit-photos', [
                    'as' => 'user.upload_photos.write.edit',
                    'uses' => 'UserSettingController@editUserPhotos',
                ]);

                // Like feed
                Route::post('/{photoUid}/like-feed', [
                    'as' => 'user.feed.write.like',
                    'uses' => 'UserSettingController@likeUserFeed',
                ]);
                // Tagged feed
                Route::post('/{photoUid}/tagged-feed', [
                    'as' => 'user.feed.write.tagged',
                    'uses' => 'UserSettingController@taggedUserFeed',
                ]);
                Route::post('/edit-feed', [
                    'as' => 'user.feed.write.edit',
                    'uses' => 'UserSettingController@editUserFeed',
                ]);
                Route::post('/comment-feed', [
                    'as' => 'user.feed.write.comment',
                    'uses' => 'UserSettingController@commentUserFeed',
                ]);

                // Process setting of account
                Route::post('/process-usersetting-account', [
                    'as' => 'user.write.usersetting-account',
                    'uses' => 'UserSettingController@processUserSettingAccount',
                ]);
                // Process interests/expertise data
                Route::post('/process-expertise-data', [
                    'as' => 'user.write.expertise_data',
                    'uses' => 'UserSettingController@processExpertiseData',
                ]);

                Route::post('/store-session-data', [
                    'as' => 'user.write.store_session_data',
                    'uses' => 'UserSettingController@processStoreSessionData',
                ]);

                Route::post('/delete-session-data', [
                    'as' => 'user.write.delete_session_data',
                    'uses' => 'UserSettingController@processRemoveSessionData',
                ]);

                // Process setting account
                Route::post('/process-setting-account', [
                    'as' => 'user.write.setting-account',
                    'uses' => 'UserSettingController@processSettingAccount',
                ]);
                Route::post('/process-setting-privacy', [
                    'as' => 'user.write.setting-privacy',
                    'uses' => 'UserSettingController@processSettingPrivacy',
                ]);

                Route::post('/process-setting-subscription', [
                    'as' => 'user.write.setting-subscription',
                    'uses' => 'UserSettingController@processSettingSubscription',
                ]);

                Route::post('/process-setting-cancel-subscription', [
                    'as' => 'user.write.setting-subscription-cancel',
                    'uses' => 'UserSettingController@processSettingCancelSubscription',
                ]);

                Route::post('/process-setting-updatecard-subscription', [
                    'as' => 'user.write.setting-subscription-updatecard',
                    'uses' => 'UserSettingController@processSettingUpdateCardSubscription',
                ]);

                Route::post('/process-setting-updatecard-subscription-downgrade', [
                    'as' => 'user.write.setting-subscription-downgrade',
                    'uses' => 'UserSettingController@processSettingDowngradeSubscription',
                ]);

                Route::post('/process-setting-updatecard-subscription-upgrade', [
                    'as' => 'user.write.setting-subscription-upgrade',
                    'uses' => 'UserSettingController@processSettingUpgradeSubscription',
                ]);

                Route::post('/process-setting-subscription-sponser', [
                    'as' => 'user.write.setting-subscription-sponser',
                    'uses' => 'UserSettingController@processSettingSubscriptionSponser',
                ]);

                Route::post('/process-setting-cancel-subscription-sponser', [
                    'as' => 'user.write.setting-subscription-sponser-cancel',
                    'uses' => 'UserSettingController@processSettingCancelSubscriptionSponser',
                ]);

                Route::post('/process-setting-updatecard-subscription-sponser', [
                    'as' => 'user.write.setting-subscription-sponser-updatecard',
                    'uses' => 'UserSettingController@processSettingUpdateCardSubscriptionSponser',
                ]);
                
            });

            // User Messenger related routes
            Route::group([
                'namespace' => 'Messenger\Controllers',
                'prefix' => 'messenger',
            ], function () {
                // Get All Conversation
                Route::get('/', [
                    'as' => 'user.read.messenger',
                    'uses' => 'MessengerController@show',
                ]);
                // Get All Conversation
                Route::get('/all-conversation', [
                    'as' => 'user.read.all_conversation',
                    'uses' => 'MessengerController@getAllConversation',
                ]);
                // Get Specific Conversation
                Route::get('/{specificUserId}/individual-conversation', [
                    'as' => 'user.read.individual_conversation',
                    'uses' => 'MessengerController@getIndividualConversation',
                ]);
                // Get Conversation List
                Route::get('/{userId}/get-user-conversation', [
                    'as' => 'user.read.user_conversation',
                    'uses' => 'MessengerController@getUserConversation',
                ]);
                // get chat candidates
                Route::post('/get-all-candidate', [
                    'as' => 'user.read.get_candidates',
                    'uses' => 'MessengerController@getMessengerCandidates',
                ]);
                // Send message
                Route::post('/{userId}/process-send-message', [
                    'as' => 'user.write.send_message',
                    'uses' => 'MessengerController@sendMessage',
                ]);
                // Send inquire message
                Route::post('/process-send-inquire-message', [
                    'as' => 'user.write.send_inquire_message',
                    'uses' => 'MessengerController@sendInquireMessage',
                ]);

                // Send inquire message
                Route::post('/process-send-invite-message', [
                    'as' => 'user.write.send_invite_message',
                    'uses' => 'MessengerController@sendInviteMessage',
                ]);

                // Accept / Decline Message request
                Route::post('/{userId}/process-accept-decline-message-request', [
                    'as' => 'user.write.accept_decline_message_request',
                    'uses' => 'MessengerController@acceptDeclineMessageRequest',
                ]);
                // Delete Single Chat
                Route::post('/{chatId}/{userId}/delete-message', [
                    'as' => 'user.write.delete_message',
                    'uses' => 'MessengerController@deleteMessage',
                ]);
                // Get Call Token Data
                Route::post('/{userUId}/{type}/call-initialize', [
                    'as' => 'user.write.caller.call_initialize',
                    'uses' => 'MessengerController@callerCallInitialize',
                ]);
                // Get Call Token Data
                Route::post('/join-call', [
                    'as' => 'user.write.receiver.join_call',
                    'uses' => 'MessengerController@receiverJoinCallRequest',
                ]);
                // Caller Call Reject
                Route::get('/{receiverUserUid}/caller-reject-call', [
                    'as' => 'user.write.caller.reject_call',
                    'uses' => 'MessengerController@callerRejectCall',
                ]);
                // Receiver Call Reject
                Route::get('/{callerUserUid}/receiver-reject-call', [
                    'as' => 'user.write.receiver.reject_call',
                    'uses' => 'MessengerController@receiverRejectCall',
                ]);
                // Caller call errors
                Route::get('/{receiverUserUid}/caller-errors', [
                    'as' => 'user.write.caller.error',
                    'uses' => 'MessengerController@callerCallErrors',
                ]);
                // Receiver call errors
                Route::get('/{callerUserUid}/receiver-errors', [
                    'as' => 'user.write.receiver.error',
                    'uses' => 'MessengerController@receiverCallErrors',
                ]);
                // Receiver call accept
                Route::post('/{receiverUserUid}/receiver-call-accept', [
                    'as' => 'user.write.receiver.call_accept',
                    'uses' => 'MessengerController@receiverCallAccept',
                ]);
                // Receiver call errors
                Route::get('/{callerUserUid}/receiver-busy-call', [
                    'as' => 'user.write.receiver.call_busy',
                    'uses' => 'MessengerController@receiverCallBusy',
                ]);
                // Delete all chat conversation
                Route::post('/{userId}/delete-all-message', [
                    'as' => 'user.write.delete_all_messages',
                    'uses' => 'MessengerController@deleteAllMessages',
                ]);
                // Get Stickers
                Route::get('/get-stickers', [
                    'as' => 'user.read.get_stickers',
                    'uses' => 'MessengerController@getStickers',
                ]);
                // Buy Sticker
                Route::post('/process-buy-sticker', [
                    'as' => 'user.write.buy_stickers',
                    'uses' => 'MessengerController@buySticker',
                ]);
                
            });

            // User Notification related routes
            Route::group([
                'namespace' => 'Notification\Controllers',
                'prefix' => 'notifications',
            ], function () {
                // Get mutual likes users
                Route::get('/', [
                    'as' => 'user.notification.read.view',
                    'uses' => 'NotificationController@getNotificationView',
                ]);

                // Get mutual likes users
                Route::get('/notification-list', [
                    'as' => 'user.notification.read.list',
                    'uses' => 'NotificationController@getNotificationList',
                ]);
                
                // Post Read All Notification
                Route::post('/read-all-notification', [
                    'as' => 'user.notification.write.read_all_notification',
                    'uses' => 'NotificationController@readAllNotification',
                ]);
            });

            // User Encounter related routes
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'encounters',
            ], function () {
                // Get users encounter view
                Route::get('/', [
                    'as' => 'user.read.encounter.view',
                    'uses' => 'UserEncounterController@getUserEncounterView',
                ]);

                // User Like Dislike route
                Route::post('/{toUserUid}/{like}/user-encounter-like-dislike', [
                    'as' => 'user.write.encounter.like_dislike',
                    'uses' => 'UserEncounterController@userEncounterLikeDislike',
                ]);

                // Skip Encounter User
                Route::post('/{toUserUid}/skip-encounter-user', [
                    'as' => 'user.write.encounter.skip_user',
                    'uses' => 'UserEncounterController@skipEncounterUser',
                ]);
            });

            /*
            Manage Premium Plan User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'premium',
            ], function () {
                // User Premium Plan View
                Route::get('/', [
                    'as' => 'user.premium_plan.read.view',
                    'uses' => 'PremiumPlanController@getPremiumPlanView',
                ]);

                // buy premium plans
                Route::post('/buy-plans', [
                    'as' => 'user.premium_plan.write.buy_premium_plan',
                    'uses' => 'PremiumPlanController@buyPremiumPlans',
                ]);

                // User Premium Plan Buy Successfully
                Route::get('/success', [
                    'as' => 'user.premium_plan.read.success_view',
                    'uses' => 'PremiumPlanController@getPremiumPlanSuccessView',
                ]);
            });

            /*
        	Credit wallet User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'credit-wallet',
            ], function () {
                // User Credit-wallet View
                Route::get('/', [
                    'as' => 'user.credit_wallet.read.view',
                    'uses' => 'CreditWalletController@creditWalletView',
                ]);

                // Public User Wallet transaction list
                Route::get('/user-wallet-transaction-list', [
                    'as' => 'user.credit_wallet.read.wallet_transaction_list',
                    'uses' => 'CreditWalletController@getUserWalletTransactionList',
                ]);

                // paypal transaction complete
                Route::post('/{packageUid}/paypal-transaction-complete', [
                    'as' => 'user.credit_wallet.write.paypal_transaction_complete',
                    'uses' => 'CreditWalletController@paypalTransactionComplete',
                ]);

                // stripe checkout routes
                Route::post('/payment-process', [
                    'as' => 'user.credit_wallet.write.payment_process',
                    'uses' => 'CreditWalletController@paymentProcess',
                ]);

                // stripe success callback routes
                Route::get('/stripe-callback', [
                    'as' => 'user.credit_wallet.write.stripe.callback_url',
                    'uses' => 'CreditWalletController@stripeCallbackUrl',
                ]);

                // stripe checkout cancel url
                Route::get('/stripe-cancel', [
                    'as' => 'user.credit_wallet.write.stripe.cancel_url',
                    'uses' => 'CreditWalletController@stripeCancelCallback',
                ]);

                // razorpay checkout
                Route::post('/razorpay-checkout', [
                    'as' => 'user.credit_wallet.write.razorpay.checkout',
                    'uses' => 'CreditWalletController@razorpayCheckout',
                ]);
            });
        });
        /*
         * User Section End here
        ----------------------------------------------------------------------- */

        /*
         * Manage / Admin Section
        ----------------------------------------------------------------------- */
        Route::group([
            'middleware' => 'admin.auth',
            'prefix' => 'admin',
        ], function () {
            /*
            Manage User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'manage/user',
            ], function () {
                // Manage User List
                Route::get('/{status}/list', [
                    'as' => 'manage.user.view_list',
                    'uses' => 'ManageUserController@userList',
                ]);

                // Manage User Photos List
                Route::get('/photos', [
                    'as' => 'manage.user.photos_list',
                    'uses' => 'ManageUserController@userPhotosView',
                ]);

                // Manage User Photos List
                Route::get('/photos-list', [
                    'as' => 'manage.user.read.photos_list',
                    'uses' => 'ManageUserController@userPhotosList',
                ]);

                // Delete User photo
                Route::post('/{userUid}/{type}/{profileOrPhotoUid}/process-delete-photo', [
                    'as' => 'manage.user.write.photo_delete',
                    'uses' => 'ManageUserController@processUserPhotoDelete',
                ]);


                // Manage User Subscriptions List
                Route::get('/subscriptions', [
                    'as' => 'manage.user.subscriptions_list',
                    'uses' => 'ManageUserController@userSubscriptionsView',
                ]);

                // Manage User Subscriptions List
                Route::get('/subscriptions-list', [
                    'as' => 'manage.user.read.subscriptions_list',
                    'uses' => 'ManageUserController@userSubscriptionsList',
                ]);

                // Delete User photo
                Route::post('/{userUid}/{subscriptionUid}/process-delete-subscription', [
                    'as' => 'manage.user.write.subscription_delete',
                    'uses' => 'ManageUserController@processUserSubscriptionDelete',
                ]);

                // Manage User List
                Route::get('/{status}/users-list', [
                    'as' => 'manage.user.read.list',
                    'uses' => 'ManageUserController@userDataTableList',
                ]);

                // Add New User
                Route::get('/add', [
                    'as' => 'manage.user.add',
                    'uses' => 'ManageUserController@addNewUserView',
                ]);
                // Add New User Process
                Route::post('/process-add', [
                    'as' => 'manage.user.write.create',
                    'uses' => 'ManageUserController@processAddNewUser',
                ]);
                // Edit User
                Route::get('/{userUid}/edit', [
                    'as' => 'manage.user.edit',
                    'uses' => 'ManageUserController@editUser',
                ]);
                // Update User
                Route::post('/{userUid}/process-update', [
                    'as' => 'manage.user.write.update',
                    'uses' => 'ManageUserController@processUpdateUser',
                ]);
                // Soft Delete User
                Route::post('/{userUid}/process-soft-delete', [
                    'as' => 'manage.user.write.soft_delete',
                    'uses' => 'ManageUserController@processUserSoftDelete',
                ]);
                // Permanent  Delete User
                Route::post('/{userUid}/process-permanent-delete', [
                    'as' => 'manage.user.write.permanent_delete',
                    'uses' => 'ManageUserController@processUserPermanentDelete',
                ]);
                // Restore User
                Route::post('/{userUid}/process-restore-user', [
                    'as' => 'manage.user.write.restore_user',
                    'uses' => 'ManageUserController@processRestoreUser',
                ]);
                // Blocked User
                Route::post('/{userUid}/process-block-user', [
                    'as' => 'manage.user.write.block_user',
                    'uses' => 'ManageUserController@processUserBlock',
                ]);
                // Unblocked User
                Route::post('/{userUid}/process-unblock-user', [
                    'as' => 'manage.user.write.unblock_user',
                    'uses' => 'ManageUserController@processUserUnblock',
                ]);
                // Show User Details
                Route::get('/{userUid}/details', [
                    'as' => 'manage.user.read.details',
                    'uses' => 'ManageUserController@getUserDetails',
                ]);

                // Verify user profile
                Route::post('/{userUid}/verify-profile', [
                    'as' => 'manage.user.write.verify',
                    'uses' => 'ManageUserController@processVerifyUserProfile',
                ]);

                // Manage User transaction list
                Route::get('/{userUid}/manage-user-transaction-list', [
                    'as' => 'manage.user.read.transaction_list',
                    'uses' => 'ManageUserController@manageUserTransactionList',
                ]);
            });

            /*
            Manage Credit Package Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'CreditPackage\Controllers',
                'prefix' => 'manage/credit-package',
            ], function () {
                //list
                Route::get('/list', [
                    'as' => 'manage.credit_package.read.list',
                    'uses' => 'CreditPackageController@getCreditPackageList',
                ]);

                // Package add view
                Route::get('/add-package', [
                    'as' => 'manage.credit_package.add.view',
                    'uses' => 'CreditPackageController@packageAddView',
                ]);

                // Package add
                Route::post('/add-package-process', [
                    'as' => 'manage.credit_package.write.add',
                    'uses' => 'CreditPackageController@addPackage',
                ]);

                // Package edit view
                Route::get('/{packageUId}/edit-package', [
                    'as' => 'manage.credit_package.edit.view',
                    'uses' => 'CreditPackageController@packageEditView',
                ]);

                // Package edit process
                Route::post('/{packageUId}/edit-package-process', [
                    'as' => 'manage.credit_package.write.edit',
                    'uses' => 'CreditPackageController@editPackage',
                ]);

                // Package delete view
                Route::post('/{packageUId}/delete-package', [
                    'as' => 'manage.credit_package.write.delete',
                    'uses' => 'CreditPackageController@processDeletePackage',
                ]);
            });

            /*
            Manage Credit wallet User Components Public Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'User\Controllers',
                'prefix' => 'manage/fake-user',
            ], function () {
                // Add New User
                Route::get('/generate', [
                    'as' => 'manage.fake_users.read.generator_options',
                    'uses' => 'ManageUserController@fetchFakeUserOptions',
                ]);
                // Add New User Process
                Route::post('/generate-fake-users', [
                    'as' => 'manage.fake_users.write.create',
                    'uses' => 'ManageUserController@generateFakeUser',
                ]);
            });

            /*
            Media Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Media\Controllers',
                'prefix' => 'media',
            ], function () {
                // Temp Upload
                Route::post('/upload-temp-media', [
                    'as' => 'media.upload_temp_media',
                    'uses' => 'MediaController@uploadTempMedia',
                ]);
                // Gift Temp Upload
                Route::post('/upload-gift-temp-media', [
                    'as' => 'media.gift.upload_temp_media',
                    'uses' => 'MediaController@uploadGiftTempMedia',
                ]);
                // Gyms Temp Upload
                Route::post('/upload-gyms-temp-media', [
                    'as' => 'media.gyms.upload_temp_media',
                    'uses' => 'MediaController@uploadGymsTempMedia',
                ]);
                // Sticker Temp Upload
                Route::post('/upload-sticker-temp-media', [
                    'as' => 'media.sticker.upload_temp_media',
                    'uses' => 'MediaController@uploadStickerTempMedia',
                ]);
                // Package Temp Upload
                Route::post('/upload-package-temp-media', [
                    'as' => 'media.package.upload_temp_media',
                    'uses' => 'MediaController@uploadPackageTempMedia',
                ]);
                // Upload Logo
                Route::post('/upload-logo', [
                    'as' => 'media.upload_logo',
                    'uses' => 'MediaController@uploadLogo',
                ]);
                // Upload Small Logo
                Route::post('/upload-small-logo', [
                    'as' => 'media.upload_small_logo',
                    'uses' => 'MediaController@uploadSmallLogo',
                ]);
                // Upload Favicon
                Route::post('/upload-favicon', [
                    'as' => 'media.upload_favicon',
                    'uses' => 'MediaController@uploadFavicon',
                ]);
            });

            /*
            Dashboard Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Dashboard\Controllers',
            ], function () {
                // dashboard view
                Route::get('/', [
                    'as' => 'manage.dashboard',
                    'uses' => 'DashboardController@loadDashboardView',
                ]);
            });

            /*
            Configuration Component Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Configuration\Controllers',
                'prefix' => 'configuration',
            ], function () {
                // Clear Cache Everything
                Route::get('/licence-information', [
                    'as' => 'manage.configuration.product_registration',
                    'uses' => 'ConfigurationController@registerProductView',
                ]);

                Route::post('/licence-information-process', [
                    'as' => 'installation.version.create.registration',
                    'uses' => 'ConfigurationController@processProductRegistration',
                ]);

                Route::post('/licence-information-remove-process', [
                    'as' => 'installation.version.create.remove_registration',
                    'uses' => 'ConfigurationController@processProductRegistrationRemoval',
                ]);

                // Clear Cache Everything
                Route::get('/clear-system-cache', [
                    'as' => 'manage.configuration.clear_cache',
                    'uses' => 'ConfigurationController@clearSystemCache',
                ]);

                // View Configuration View
                Route::get('/{pageType}', [
                    'as' => 'manage.configuration.read',
                    'uses' => 'ConfigurationController@getConfiguration',
                ]);
                // Process Configuration Data
                Route::post('/{pageType}/process-configuration-store', [
                    'as' => 'manage.configuration.write',
                    'uses' => 'ConfigurationController@processStoreConfiguration',
                ]);
            });

            /*
            Manage Financial transaction Components Manage Section Related Routes
            ----------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'FinancialTransaction\Controllers',
                'prefix' => 'financial-transaction',
            ], function () {
                //Manage Financial transaction transaction View
                Route::get('/{transactionType}/list', [
                    'as' => 'manage.financial_transaction.read.view_list',
                    'uses' => 'FinancialTransactionController@financialTransactionViewList',
                ]);

                // Financial transaction list
                Route::get('/{transactionType}/transaction-list', [
                    'as' => 'manage.financial_transaction.read.list',
                    'uses' => 'FinancialTransactionController@getTransactionList',
                ]);

                // Delete all test transaction
                Route::post('/delete-all-test-transaction', [
                    'as' => 'manage.financial_transaction.write.delete.all_transaction',
                    'uses' => 'FinancialTransactionController@deleteAllTestTransaction',
                ]);
            });

            /*
            Pages Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Pages\Controllers',
                'prefix' => 'pages',
            ], function () {
                // pages view
                Route::get('/', [
                    'as' => 'manage.page.view',
                    'uses' => 'ManagePagesController@pageListView',
                ]);

                // pages view
                Route::get('/list', [
                    'as' => 'manage.page.list',
                    'uses' => 'ManagePagesController@getDatatableData',
                ]);

                // pages add view
                Route::get('/add', [
                    'as' => 'manage.page.add.view',
                    'uses' => 'ManagePagesController@pageAddView',
                ]);

                // pages add process
                Route::post('/page-add-process', [
                    'as' => 'manage.page.write.add',
                    'uses' => 'ManagePagesController@processAddPage',
                ]);

                // pages edit view
                Route::get('/{pageUId}/edit', [
                    'as' => 'manage.page.edit.view',
                    'uses' => 'ManagePagesController@pageEditView',
                ]);

                // pages edit process
                Route::post('/{pageUId}/page-edit-process', [
                    'as' => 'manage.page.write.edit',
                    'uses' => 'ManagePagesController@processEditPage',
                ]);

                // pages delete process
                Route::post('/{pageUId}/page-delete', [
                    'as' => 'manage.page.write.delete',
                    'uses' => 'ManagePagesController@delete',
                ]);
            });

            /*
            Expertise Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Expertise\Controllers',
                'prefix' => 'expertise',
            ], function () {
                // pages view
                Route::get('/', [
                    'as' => 'manage.expertise.view',
                    'uses' => 'ManageExpertiseController@expertiseListView',
                ]);

                // pages view
                Route::get('/list', [
                    'as' => 'manage.expertise.list',
                    'uses' => 'ManageExpertiseController@getDatatableData',
                ]);

                // pages add view
                Route::get('/add', [
                    'as' => 'manage.expertise.add.view',
                    'uses' => 'ManageExpertiseController@expertiseAddView',
                ]);

                // pages add process
                Route::post('/expertise-add-process', [
                    'as' => 'manage.expertise.write.add',
                    'uses' => 'ManageExpertiseController@processAddExpertise',
                ]);

                // pages edit view
                Route::get('/{expertiseUId}/edit', [
                    'as' => 'manage.expertise.edit.view',
                    'uses' => 'ManageExpertiseController@expertiseEditView',
                ]);

                // pages edit process
                Route::post('/{expertiseUId}/expertise-edit-process', [
                    'as' => 'manage.expertise.write.edit',
                    'uses' => 'ManageExpertiseController@processEditExpertise',
                ]);

                // pages delete process
                Route::post('/{expertiseUId}/expertise-delete', [
                    'as' => 'manage.expertise.write.delete',
                    'uses' => 'ManageExpertiseController@delete',
                ]);
            });

            Route::group([
                'namespace' => 'PricingType\Controllers',
                'prefix' => 'pricingtype',
            ], function () {
                // pages view
                Route::get('/', [
                    'as' => 'manage.pricingtype.view',
                    'uses' => 'ManagePricingTypeController@pricingtypeListView',
                ]);

                // pages view
                Route::get('/list', [
                    'as' => 'manage.pricingtype.list',
                    'uses' => 'ManagePricingTypeController@getDatatableData',
                ]);

                // pages add view
                Route::get('/add', [
                    'as' => 'manage.pricingtype.add.view',
                    'uses' => 'ManagePricingTypeController@pricingtypeAddView',
                ]);

                // pages add process
                Route::post('/pricingtype-add-process', [
                    'as' => 'manage.pricingtype.write.add',
                    'uses' => 'ManagePricingTypeController@processAddPricingType',
                ]);

                // pages edit view
                Route::get('/{pricingtypeUId}/edit', [
                    'as' => 'manage.pricingtype.edit.view',
                    'uses' => 'ManagePricingTypeController@pricingtypeEditView',
                ]);

                // pages edit process
                Route::post('/{pricingtypeUId}/pricingtype-edit-process', [
                    'as' => 'manage.pricingtype.write.edit',
                    'uses' => 'ManagePricingTypeController@processEditPricingType',
                ]);

                // pages delete process
                Route::post('/{pricingtypeUId}/pricingtype-delete', [
                    'as' => 'manage.pricingtype.write.delete',
                    'uses' => 'ManagePricingTypeController@delete',
                ]);
            });


            /*
            SupportRequest Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'SupportRequest\Controllers',
                'prefix' => 'support',
            ], function () {
                // pages view
                Route::get('/', [
                    'as' => 'manage.support.view',
                    'uses' => 'ManageSupportRequestController@supportListView',
                ]);

                // pages view
                Route::get('/list', [
                    'as' => 'manage.support.list',
                    'uses' => 'ManageSupportRequestController@getDatatableData',
                ]);

                // pages add view
                Route::get('/add', [
                    'as' => 'manage.support.add.view',
                    'uses' => 'ManageSupportRequestController@supportAddView',
                ]);

                // pages add process
                Route::post('/support-add-process', [
                    'as' => 'manage.support.write.add',
                    'uses' => 'ManageSupportRequestController@processAddSupport',
                ]);

                // pages edit view
                Route::get('/{supportUId}/edit', [
                    'as' => 'manage.support.edit.view',
                    'uses' => 'ManageSupportRequestController@supportEditView',
                ]);

                // pages edit process
                Route::post('/{supportUId}/support-edit-process', [
                    'as' => 'manage.support.write.edit',
                    'uses' => 'ManageSupportRequestController@processEditSupport',
                ]);

                // pages delete process
                Route::post('/{supportUId}/support-delete', [
                    'as' => 'manage.support.write.delete',
                    'uses' => 'ManageSupportRequestController@delete',
                ]);
            });


            /*
            Gift Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Item\Controllers',
            ], function () {
                // Gift view
                Route::get('/gift', [
                    'as' => 'manage.item.gift.view',
                    'uses' => 'ManageGiftController@giftListView',
                ]);

                // Gift add view
                Route::get('/add-gift', [
                    'as' => 'manage.item.gift.add.view',
                    'uses' => 'ManageGiftController@giftAddView',
                ]);

                // Gift add
                Route::post('/add-gift-process', [
                    'as' => 'manage.item.gift.write.add',
                    'uses' => 'ManageGiftController@addGift',
                ]);

                // Gift edit view
                Route::get('/{giftUId}/edit-gift', [
                    'as' => 'manage.item.gift.edit.view',
                    'uses' => 'ManageGiftController@giftEditView',
                ]);

                // Gift edit process
                Route::post('/{giftUId}/edit-gift-process', [
                    'as' => 'manage.item.gift.write.edit',
                    'uses' => 'ManageGiftController@editGift',
                ]);

                // Gift delete view
                Route::post('/{giftUId}/delete-gift', [
                    'as' => 'manage.item.gift.write.delete',
                    'uses' => 'ManageGiftController@deleteGift',
                ]);

                // Sticker view
                Route::get('/sticker', [
                    'as' => 'manage.item.sticker.view',
                    'uses' => 'ManageStickerController@stickerListView',
                ]);

                // Upload Sticker image
                Route::post('/upload-sticker-image', [
                    'as' => 'manage.item.sticker.write.upload_image',
                    'uses' => 'ManageStickerController@uploadStickerImage',
                ]);

                // Sticker add view
                Route::get('/add-sticker', [
                    'as' => 'manage.item.sticker.add.view',
                    'uses' => 'ManageStickerController@stickerAddView',
                ]);

                // Sticker add
                Route::post('/add-sticker-process', [
                    'as' => 'manage.item.sticker.write.add',
                    'uses' => 'ManageStickerController@addSticker',
                ]);

                // Sticker edit view
                Route::get('/{stickerUId}/edit-sticker', [
                    'as' => 'manage.item.sticker.edit.view',
                    'uses' => 'ManageStickerController@stickerEditView',
                ]);

                // Sticker edit process
                Route::post('/{stickerUId}/edit-sticker-process', [
                    'as' => 'manage.item.sticker.write.edit',
                    'uses' => 'ManageStickerController@editSticker',
                ]);

                // Sticker delete view
                Route::post('/{stickerUId}/delete-sticker', [
                    'as' => 'manage.item.sticker.write.delete',
                    'uses' => 'ManageStickerController@deleteSticker',
                ]);
            });

            /*
            Gyms Components Manage Section Related Routes
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Gyms\Controllers',
            ], function () {
                // gyms view
                Route::get('/gyms', [
                    'as' => 'manage.gyms.view',
                    'uses' => 'ManageGymsController@gymsListView',
                ]);

                // gyms add view
                Route::get('/add-gyms', [
                    'as' => 'manage.gyms.add.view',
                    'uses' => 'ManageGymsController@gymsAddView',
                ]);

                // gyms add
                Route::post('/add-gyms-process', [
                    'as' => 'manage.gyms.write.add',
                    'uses' => 'ManageGymsController@addGyms',
                ]);

                // gyms edit view
                Route::get('/{gymsUId}/edit-gyms', [
                    'as' => 'manage.gyms.edit.view',
                    'uses' => 'ManageGymsController@gymsEditView',
                ]);

                // gyms edit process
                Route::post('/{gymsUId}/edit-gyms-process', [
                    'as' => 'manage.gyms.write.edit',
                    'uses' => 'ManageGymsController@editGyms',
                ]);

                // gyms delete view
                Route::post('/{gymsUId}/delete-gyms', [
                    'as' => 'manage.gyms.write.delete',
                    'uses' => 'ManageGymsController@deleteGyms',
                ]);

            });


            /*
            User AbuseReport Component Manage Routes Start from here
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'AbuseReport\Controllers',
                'prefix' => 'abuse-report',
            ], function () {
                // abuse report view list
                Route::get('/{status}/list', [
                    'as' => 'manage.abuse_report.read.list',
                    'uses' => 'AbuseReportController@reportListView',
                ]);

                // abuse report moderated
                Route::post('/moderate-report', [
                    'as' => 'manage.abuse_report.write.moderated',
                    'uses' => 'AbuseReportController@reportModerated',
                ]);
            });

            /*
            Manage Translations
            ------------------------------------------------------------------- */
            Route::group([
                'namespace' => 'Translation\Controllers',
                'prefix' => 'translations',
            ], function () {
                Route::get('/', [
                    'as' => 'manage.translations.languages',
                    'uses' => 'TranslationController@languages',
                ]);

                // Store New Language
                Route::post('/process-language-store', [
                    'as' => 'manage.translations.write.language_create',
                    'uses' => 'TranslationController@storeLanguage',
                ]);

                // Update Language
                Route::post('/process-language-update', [
                    'as' => 'manage.translations.write.language_update',
                    'uses' => 'TranslationController@updateLanguage',
                ]);

                // Delete Language
                Route::post('/{languageId}/process-language-delete', [
                    'as' => 'manage.translations.write.language_delete',
                    'uses' => 'TranslationController@deleteLanguage',
                ]);

                Route::get('language/{languageId}', [
                    'as' => 'manage.translations.lists',
                    'uses' => 'TranslationController@lists',
                ]);

                Route::get('/scan/{languageId}/{preventReload?}', [
                    'as' => 'manage.translations.scan',
                    'uses' => 'TranslationController@scan',
                ]);

                Route::post('/update', [
                    'as' => 'manage.translations.update',
                    'uses' => 'TranslationController@update',
                ]);

                Route::get('/export/{languageId}', [
                    'as' => 'manage.translations.export',
                    'uses' => 'TranslationController@export',
                ]);

                Route::post('/import/{languageId}', [
                    'as' => 'manage.translations.import',
                    'uses' => 'TranslationController@import',
                ]);
            });
        });
    });
});
