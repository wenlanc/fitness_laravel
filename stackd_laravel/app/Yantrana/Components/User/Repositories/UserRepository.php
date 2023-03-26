<?php

/**
 * UserRepository.php - Repository file
 *
 * This file is part of the User component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Repositories;

use Str;
use Auth;
use Request;
use DB;
use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\User\Blueprints\UserRepositoryBlueprint;
use App\Yantrana\Components\User\Models\{
    User as UserModel,
    UserAuthorityModel,
    PasswordReset,
    SocialAccess,
    LikeDislikeModal,
    ProfileVisitorModel,
    UserGiftModel,
    CreditWalletTransaction,
    UserSubscription,
    UserBlock,
    ProfileBoost,
    UserProfile,
    UserTime,
    UserGym,
    UserExpertise,
    UserPricing,
    UserReview,
    UserPhoto,
    UserFeed,
    UserPhotoComment
};
use App\Yantrana\Components\User\Models\LoginAttempt;
use App\Yantrana\Components\Expertise\Models\ExpertiseModel;
use YesSecurity;
use App\Yantrana\Support\Utils;
use Carbon\Carbon;

class UserRepository extends BaseRepository implements UserRepositoryBlueprint
{

    /**
     * Constructor.
     *
     * @param UserModel $user - User Model
     *-----------------------------------------------------------------------*/
    public function __construct(UserModel $user = null)
    {
        //if it is not null
        if ($user) {
            $user = new UserModel;
        }
        $this->user = $user;
    }

    /**
     * Fetch user by id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchByID($userID)
    {
        return UserModel::find($userID);
    }

    /**
     * Fetch user subscription data by logged in user id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchUserSubscription()
    {
        //get current date time
        $currentDateTime = Carbon::now();
        return UserSubscription::leftJoin('credit_wallet_transactions', 'user_subscriptions.credit_wallet_transactions__id', '=', 'credit_wallet_transactions._id')
            ->select(
                __nestedKeyValues([
                    'user_subscriptions.*',
                    'credit_wallet_transactions' => [
                        'credits'
                    ]
                ])
            )
            ->where('user_subscriptions.users__id', getUserID())
            ->where('user_subscriptions.expiry_at', '>=', $currentDateTime)
            ->latest()
            ->first();
    }



    /**
     * Fetch user with profile by id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchWithProfile($userId)
    {
        return UserModel::where('users._id', $userId)
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->select(
                __nestedKeyValues([
                    'users' => ['*'],
                    'user_profiles' => [
                        '_id AS user_profile_id',
                        '_uid AS user_profile_uid',
                        'profile_picture',
                        'about_me',
                        'kanji_name'
                    ],
                    'user_authorities' => [
                        'users__id AS user_authority_user_id',
                        'user_roles__id as user_role_id',
                        'updated_at'   //  AS userAuthorityUpdatedAt
                    ]
                ])
            )
            ->first();
    }

    /**
     * Fetch user with profile by id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchUsersWithProfiles($userIds)
    {
        return UserModel::whereIn('users._id', $userIds)
            ->join('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->select(
                \__nestedKeyValues([
                    'users' => [
                        '_id AS user_id',
                        '_uid AS user_uid',
                        'first_name',
                        'last_name'
                    ],
                    'user_profiles' => [
                        '_id AS user_profile_id',
                        '_uid AS user_profile_uid',
                        'profile_picture',
                        'about_me'
                    ],
                    'user_authorities' => [
                        'users__id AS user_authority_user_id',
                        'updated_at'
                    ]
                ])
            )
            ->get();
    }

    /**
     * fetch user data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')->select(__nestedKeyValues([
                'users.*',
                'user_authorities.user_roles__id as user_role_id',
                'user_authorities' => [
                    'updated_at as userAuthorityUpdatedAt'
                ]
            ]))->where('users._id', $idOrUid)->first();
        } else {
            return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')->select(__nestedKeyValues([
                'users.*',
                'user_authorities.user_roles__id as user_role_id',
                'user_authorities' => [
                    'updated_at as userAuthorityUpdatedAt'
                ]
            ]))->where('users._uid', $idOrUid)->first();
        }
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchByEmail($email)
    {
        return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->select(
                __nestedKeyValues([
                    'users.*',
                    'user_authorities' => [
                        '_id as user_authority_id',
                        'updated_at as user_authority_updated_at'
                    ]
                ])
            )->where('email', $email)->first();
    }

    /**
     * Fetch the record of all User like dislike by logged in user id
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchAllUserLikeDislike()
    {
        return LikeDislikeModal::leftJoin('users', 'like_dislikes.to_users__id', '=', 'users._id')
            ->select(
                __nestedKeyValues([
                    'like_dislikes.*',
                    'users' => [
                        '_id',
                        'status as userStatus'
                    ]
                ])
            )
            ->where('by_users__id', getUserID())
            ->where('users.status', 1)
            ->where('like_dislikes.status', '<>' ,0)
            ->get();
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchLikeDislike($toUserId)
    {
        return LikeDislikeModal::where('by_users__id', getUserID())
            ->where('to_users__id', $toUserId)
            ->where('status','<>', 0)
            ->first();
    }

    public function fetchLikeDislikeToMe($toUserId)
    {
        return LikeDislikeModal::where('by_users__id', $toUserId)
            ->where('to_users__id', getUserID())
            ->where('status','<>', 0)
            ->first();
    }

    public function fetchCountFollowToday($userId) {

        return LikeDislikeModal::where('by_users__id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function checkMutualFollow($toUserId)
    {
        $following =  LikeDislikeModal::where('by_users__id', getUserID())
            ->where('to_users__id', $toUserId)
            ->where('status','<>', 0)
            ->first();
        $follower =   LikeDislikeModal::where('by_users__id', $toUserId)
        ->where('to_users__id', getUserID())
        ->where('status','<>', 0)
        ->first();
        // if(__isEmpty($following) || __isEmpty($follower)) {
        //     return getUserID();
        // }

        //if(isAdmin()) {
        //    return 1;
        //}

        if(__isEmpty($following)) {
            return 0;
        }
        if(__isEmpty($follower)) {
            return 0;
        }
        return 1;
    }

    /**
     * Fetch the record of Block user data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchBlockUser($toUserId)
    {
        return UserBlock::where('to_users__id', $toUserId)
            ->where('by_users__id', getUserID())
            ->first();
    }

    /**
     * Fetch the record of Block user data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchBlockMeUser($byUserId)
    {
        return UserBlock::where('to_users__id', getUserID())
            ->where('by_users__id', $byUserId)
            ->first();
    }

    /**
     * Fetch the record of All Block me user data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAllBlockMeUser()
    {
        return UserBlock::where('to_users__id', getUserID())
            ->get();
    }

    /**
     * Fetch the record of All Block user data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAllBlockUser($paginate = false)
    {
        $query =  UserBlock::leftJoin('users', 'user_block_users.to_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'user_block_users.to_users__id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->select(
                __nestedKeyValues([
                    'user_block_users.*',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob'
                    ],
                    'countries' => [
                        'name as countryName'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ]
                ])
            )
            ->where('user_block_users.by_users__id', getUserID());

        if ($paginate) {
            return $query->paginate(configItem('paginate_count'));
        }

        return $query->get();
    }

    /**
     * Fetch the record of My liked User
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchMyLikeDataByUserId($userId)
    {
        return  LikeDislikeModal::where('like', 1)
            ->where('by_users__id', $userId)
            ->where('status', '<>',  0)
            ->get();
    }

    /**
     * Fetch the record of User liked
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchUserLikeData($like, $paginate = false)
    {
        $query =  LikeDislikeModal::leftJoin('users', 'like_dislikes.to_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->select(
                __nestedKeyValues([
                    'like_dislikes.*',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        'status',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as userProfileId',
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'countries' => [
                        'name as countryName'
                    ],
                ])
            )
            ->where('like_dislikes.like', $like)
            ->where('like_dislikes.status', '<>', 0)
            ->where('users.status', '=', 1)
            ->where('by_users__id', getUserID());
        if ($paginate) {
            return $query->paginate(configItem('paginate_count'));
        }

        return $query->get();
    }

    /**
     * Fetch the record of User liked
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchUserLikeMeData($paginate = false)
    {
        $query =  LikeDislikeModal::leftJoin('users', 'like_dislikes.by_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->select(
                __nestedKeyValues([
                    'like_dislikes.*',
                    'like_dislikes.status as like_status',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        'status as user_status',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as userProfileId',
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'countries' => [
                        'name as countryName'
                    ]
                ])
            )
            ->where('like_dislikes.status', '<>', 0)
            ->where('like_dislikes.like', 1)
            ->where('users.status', '=', 1)
            ->where('to_users__id', getUserID());

        if ($paginate) {
            return $query->paginate(configItem('paginate_count'));
        }

        return $query->get();
    }

    /**
     * Fetch the record of Mutual User liked
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchMutualLikeUserData($mutualLikeIds)
    {
        return LikeDislikeModal::leftJoin('users', 'like_dislikes.by_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->select(
                __nestedKeyValues([
                    'like_dislikes.*',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        'status',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as userProfileId',
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'countries' => [
                        'name as countryName'
                    ]
                ])
            )
            ->whereIn('like_dislikes._id', $mutualLikeIds)
            ->where('users._id', '!=', getUserID())
            ->where('users.status', '=', 1)
            ->where('like_dislikes.status', '<>', 0)
            ->paginate(configItem('paginate_count'));
    }

    /**
     * Fetch the record of profile visitors by user ids
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetProfileVisitorByUserId($userId)
    {
        return ProfileVisitorModel::where('to_users__id', $userId)
            ->where('by_users__id', getUserID())
            ->first();
    }

    /**
     * Fetch the record of User Gift
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchUserGift($userId)
    {
        return UserGiftModel::leftJoin('items', 'user_gifts.items__id', '=', 'items._id')
            ->leftJoin('users', 'user_gifts.from_users__id', '=', 'users._id')
            ->select(
                __nestedKeyValues([
                    'user_gifts' => [
                        '_id',
                        '_uid',
                        'items__id',
                        'status',
                        'to_users__id',
                        'from_users__id'
                    ],
                    'items' => [
                        '_id as itemId',
                        '_uid as itemUId',
                        'title',
                        'file_name'
                    ],
                    'users' => [
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS fromUserName'),
                        'username as senderUserName'
                    ]
                ])
            )
            ->where('user_gifts.to_users__id', $userId)
            ->latest('user_gifts.created_at')
            ->get();
    }

    /**
     * Fetch the record of user like data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchProfileVisitor($toUserId)
    {
        return ProfileVisitorModel::leftJoin('users', 'profile_visitors.by_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->select(
                __nestedKeyValues([
                    'profile_visitors.*',
                    'users' => [
                        '_id as userId',
                        'status as userStatus'
                    ]
                ])
            )
            ->where('profile_visitors.to_users__id', $toUserId)
            ->where('profile_visitors.status', 1)
            ->where('user_authorities.user_roles__id','<>', 1)
            ->where('users.status', 1)
            ->get();
    }

    /**
     * Fetch the record of User liked
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchProfileVisitorData($premiumUserIds)
    {
        return ProfileVisitorModel::leftJoin('users', 'profile_visitors.by_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->select(
                __nestedKeyValues([
                    'profile_visitors.*',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        'status',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as userProfileId',
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob'
                    ],
                    'countries' => [
                        'name as countryName'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ]
                ])
            )
            ->where(function ($query) use ($premiumUserIds) {
                //check if browse incognito mode is only for premium user then apply this condition
                if (getStoreSettings('feature_plans')['browse_incognito_mode']['select_user'] == 2) {
                    $query->whereNotIn('users._id', $premiumUserIds);
                }
            })
            ->where('to_users__id', getUserID())
            ->where('users.status', '=', 1)
            ->paginate(configItem('paginate_count'));
    }

    public function fetchUserGymData($userId)
    {
        return UserGym::leftJoin('gym', 'user_gym.gym_id', '=', 'gym._id')
            ->select(
                __nestedKeyValues([
                    'user_gym.*',
                    'gym' => [
                        '_id as gymId',
                        '_uid as gymUId',
                        'name as gymName',
                        'logo_image as gymLogo',
                    ]
                ])
            )
            ->where('users__id', $userId )
            ->where('user_gym.status', 1)
            ->get();
    }

    public function fetchUserExpertiseData($userId)
    {
        return UserExpertise::leftJoin('expertise', 'user_expertise.expertise_id', '=', 'expertise._id')
            ->select(
                __nestedKeyValues([
                    'user_expertise.*',
                    'expertise' => [
                        '_id as expertiseId',
                        '_uid as expertiseUId',
                        'title as expertiseTitle'
                    ]
                ])
            )
            ->where('users__id', $userId )
            ->where('user_expertise.status', 1)
            ->get();
    }

    public function fetchUserSessionData($userId)
    {
        return UserPricing::where('users__id', $userId )
            ->where('status', 1)
            ->get();
    }

    public function fetchUserSessionWithTypeData( $session_type, $userId )
    {
        return UserPricing::where('users__id', $userId )
            ->where('session', $session_type)
            ->first();
    }

    public function fetchExpertiseListData()
    {
        return ExpertiseModel::where('status', 1)
            ->get();
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $username
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchByName($username)
    {
        return UserModel::where('username', $username)->first();
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $username
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchByUsername($username, $checkUserStatusForAdmin = false)
    {
        return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->select(
                __nestedKeyValues([
                    'users.*',
                    'user_authorities' => [
                        '_id as userAuthorityId',
                        'user_roles__id as userRoleId',
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'user_profiles' => [
                        'kanji_name',
                        'kata_name',
                        'dob'
                    ]
                ])
            )
            ->where('users.username', $username)
            ->where(function ($query) use ($checkUserStatusForAdmin) {
                if ($checkUserStatusForAdmin and !isAdmin()) {
                    $query->where('users.status', '=', 1);
                } else if (!$checkUserStatusForAdmin) {
                    $query->where('users.status', '=', 1);
                }
            })
            ->first();
    }

    /**
     * Fetch the record of User
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchByEmailOrUsername($emailOrUsername)
    {
        return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->select(
                __nestedKeyValues([
                    'users.*',
                    'user_authorities' => [
                        '_id as user_authority_id',
                        'updated_at as user_authority_updated_at'
                    ]
                ])
            )->where(
                str_contains($emailOrUsername, '@') ? 'email' : 'username',
                $emailOrUsername
            )->first();
    }

    /**
     * Clear login attempts.
     *---------------------------------------------------------------- */
    public function clearLoginAttempts()
    {
        LoginAttempt::where('ip_address', Request::getClientIp())->delete();
    }

    /**
     * Fetch user authority
     *
     * @param int || string $value
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */

    public function fetchUserAuthority($userId)
    {
        return UserAuthorityModel::where('users__id', $userId)->first();
    }

    /**
     * Fetch active user using email address & return response.
     *
     * @param string $email
     * @param bool   $selectRecord
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchActiveUserByEmail($email)
    {
        return UserModel::where([
            'status' => 1,      // active status
            'email' => $email,
        ])->first();
    }

    /**
     * Check the account already exists
     *
     * @param string $accountId
     *
     * @return Eloquent collection object
     *-----------------------------------------------------------------------*/

    public function checkAccountId($accountId)
    {
        return  SocialAccess::where('account_id', $accountId)
            ->first();
    }

    /**
     * Prepare data for store new social user
     *
     * @param object $input
     *
     * @return bool|object
     *---------------------------------------------------------------- */
    public function storeSocialUser($input)
    {
        $keyValues = [
            'email'            => strtolower($input['email']),
            'password'         => "NO_PASSWORD",
            'status'         => 1, // Active
            'first_name'    => $input['fname'],
            'last_name'        => $input['lname'],
            'username'        => $input['username'],
            'designation'        => 'User',
            'registered_via'    => $input['provider']
        ];

        $newUser = new UserModel;

        // Check if new User added
        if ($newUser->assignInputsAndSave($input, $keyValues)) {
            return $newUser;
        }

        return false;   // on failed
    }

    /**
     * Fetch password reminder count.
     *
     * @param string $reminderToken
     * @param string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchPasswordReminderCount($reminderToken, $email = null)
    {
        return PasswordReset::where(function ($query) use ($reminderToken, $email) {

            $query->where('token', $reminderToken);

            if (!__isEmpty($email)) {
                $query->where('email', $email);
            }
        })->count();
    }

    /**
     * Update login attempts.
     *---------------------------------------------------------------- */
    public function updateLoginAttempts()
    {
        $ipAddress = Request::getClientIp();
        $keyValues = ['attempts', 'ip_address', 'created_at'];
        $loginAttempt = LoginAttempt::where('ip_address', $ipAddress)
            ->first();

        // Check if login attempt record exist for this ip address
        if (!empty($loginAttempt)) {
            $storeData = ['attempts' => $loginAttempt->attempts + 1];
            // Store New User
            if ($loginAttempt->assignInputsAndSave($storeData, $keyValues)) {
                return true;
            } else {
                return false;
            }
        } else {
            $newLoginAttempt = new LoginAttempt();
            $storeData = [
                'ip_address' => $ipAddress,
                'attempts'     => 1,
                'created_at' => getCurrentDateTime()
            ];
            // Store New User
            if ($newLoginAttempt->assignInputsAndSave($storeData, $keyValues)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Store User.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeUser($storeData)
    {
        $keyValues = [
            'email',
            'password' => bcrypt($storeData['password']),
            'status' => $storeData['status'],
            'first_name',
            'last_name',
            'username' => Str::slug($storeData['username']),
            'mobile_number' => array_get($storeData, 'mobile_number')
        ];

        //check if mobile app request then set otp else set token
        if (isMobileAppRequest()) {
            $keyValues['remember_token'] = Utils::generateStrongPassword(4, false, 'ud');
        } else {
            $keyValues['remember_token'] = YesSecurity::generateUid();
        }

        // Get Instance of user model
        $userModel = new UserModel;
        // Store New User
        if ($userModel->assignInputsAndSave($storeData, $keyValues)) {
            return $userModel;
        }
        return false;
    }

    /**
     * Update password.
     *
     * @param object $user
     * @param string $newPassword
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updatePassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);

        if ($user->save()) {
            return true;
        }

        return false;
    }

    /**
     * Delete old password reminder.
     *
     * @param string $email
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function deleteOldPasswordReminder($email)
    {
        $expiryTime = time() - config('__tech.account.password_reminder_expiry')
            * 60 * 60;

        return PasswordReset::where('email', $email)
            ->orWhere(
                DB::raw('UNIX_TIMESTAMP(created_at)'),
                '<',
                $expiryTime
            )
            ->delete();
    }

    /**
     * Delete old password reminder.
     *
     * @param string $email
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function appDeleteOldPasswordReminder($email)
    {
        $expiryTime = time() - config('__tech.account.app_password_reminder_expiry')
            * 60 * 60;

        return PasswordReset::where('email', $email)
            ->orWhere(
                DB::raw('UNIX_TIMESTAMP(created_at)'),
                '<',
                $expiryTime
            )
            ->delete();
    }

    /**
     * Store password reminder & return response.
     *
     * @param string $email
     * @param string $token
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function storePasswordReminder($storeData)
    {
        $passwordReminder = new PasswordReset();

        $keyValues = ['email', 'token', 'created_at'];

        // Store New User
        if ($passwordReminder->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Store User Authority.
     *
     * @param array $userAuthorityData
     *
     *-----------------------------------------------------------------------*/
    public function storeUserAuthority($userAuthorityData)
    {
        $keyValues = [
            'status' => 1,
            'users__id' => $userAuthorityData['user_id'],
            'user_roles__id' => $userAuthorityData['user_roles__id']
        ];
        // Get Instance of user authority model
        $userAuthorityModel = new UserAuthorityModel;
        // Store New User Authority
        if ($userAuthorityModel->assignInputsAndSave($userAuthorityData, $keyValues)) {
            return $userAuthorityModel;
        }
        return false;
    }

    /**
     * Fetch never activated user.
     *
     * @param string $userUid
     * @param string $activationKey
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchNeverActivatedUser($userUid)
    {
        return UserModel::where([
            '_uid' => $userUid,
            'status' => 4,  // never activated
        ])
            ->first();
    }

    /**
     * Fetch never activated user.
     *
     * @param string $userUid
     * @param string $activationKey
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchNeverActivatedUserForApp($email)
    {
        return UserModel::where([
            'email' => $email,
            'status' => 4,  // never activated
        ])->first();
    }

    /**
     * Fetch never activated user.
     *
     * @param number $userID
     * @param string $activationKey
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchPasswordReset($activationKey)
    {
        $passwordReminder = new PasswordReset();

        return $passwordReminder->where([
            'token' => $activationKey
        ])
            ->first();
    }

    /**
     * Activate user by updating its status information.
     *
     * @param object $user
     *
     * @return bool|object
     *---------------------------------------------------------------- */
    public function updateUser($user, $updateData)
    {
        // Check if information updated
        if ($user->modelUpdate($updateData)) {
            return $user;
        }

        return false;
    }

    /**
     * Update User Authority by updating its status information.
     *
     * @param object $user
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updateUserAuthority($userAuthority, $updateData)
    {
        // Check if information updated
        if ($userAuthority->modelUpdate($updateData)) {
            return true;
        }

        return false;
    }

    /**
     * Reset password.
     *
     * @param object $user
     * @param string $newPassword
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function resetPassword($user, $newPassword)
    {
        $user->password = bcrypt($newPassword);

        if ($user->save()) {  // Check for if user password reset

            $this->deleteOldPasswordReminder($user->email);

            return true;
        }
        return false;
    }

    /**
     * Store user likes and dislikes data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeLikeDislike($storeData)
    {

        LikeDislikeModal::where('by_users__id', $storeData['by_users__id'])
            ->where('to_users__id', $storeData['to_users__id'])->delete();

        $keyValues = [
            'status',
            'to_users__id',
            'by_users__id',
            'like'
        ];
        // Get Instance of user likes dislikes model
        $likeDislikeModal = new LikeDislikeModal;

        // Store user likes and dislikes data
        if ($likeDislikeModal->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Update like Dislike data
     *
     * @param object $likeDislikeData
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updateLikeDislike($likeDislikeData, $updateData)
    {
        // Check if information updated
        if ($likeDislikeData->modelUpdate($updateData)) {
            return true;
        }

        return false;
    }

    /**
     * Store Profile Visitors.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeProfileVisitors($storeData)
    {
        $keyValues = [
            'status',
            'to_users__id',
            'by_users__id'
        ];
        // Get Instance of profile visitors model
        $ProfileVisitorModel = new ProfileVisitorModel;

        // Store profile visitors
        if ($ProfileVisitorModel->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Store Credit Wallet.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeCreditWalletTransaction($storeData)
    {
        //wallet transaction store data
        $keyValues = [
            'status',
            'users__id',
            'credits',
            'credit_type'
        ];

        $creditWalletTransaction = new CreditWalletTransaction;
        // Check if new User added
        if ($creditWalletTransaction->assignInputsAndSave($storeData, $keyValues)) {
            return $creditWalletTransaction->_id;
        }
        return false;
    }

    /**
     * Store user Subscription data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeUserSubscription($storeData)
    {
        //wallet transaction store data
        $keyValues = [
            'status' => 1,
            'users__id',
            'expiry_at',
            'plan_id',
            'credit_wallet_transactions__id'
        ];

        $userSubscription = new UserSubscription;
        // Check if user subscription added
        if ($userSubscription->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Store User Gift.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeUserGift($storeData)
    {
        $keyValues = [
            'status',
            'from_users__id',
            'to_users__id',
            'items__id',
            'price',
            'credit_wallet_transactions__id'
        ];

        // Get Instance of user gift model
        $userGiftModel = new UserGiftModel;
        // Store user gift data
        if ($userGiftModel->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Store user Subscription data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeBlockUser($storeData)
    {
        //wallet transaction store data
        $keyValues = [
            'status',
            'to_users__id',
            'by_users__id'
        ];

        $userBlock = new UserBlock;
        // Check if user block added
        if ($userBlock->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * delete block user data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function deleteBlockUser($blockUserData)
    {
        // Check if block user deleted
        if ($blockUserData->delete()) {
            return  true;
        }

        return false;
    }

    /**
     * delete like dislike user data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function deleteLikeDislike($likeDislikeData, $isSoft = true)
    {
        if($isSoft) {
            // Check if information updated
            if ($likeDislikeData->modelUpdate( ['status' => 0] )) {
                return true;
            }
        } else {
            // Check if like dislike user data deleted
            if ($likeDislikeData->delete()) {
                return  true;
            }
        }

        return false;
    }

    /**
     * fetch active profile boost user.
     *
     * @param array $userID
     *
     *-----------------------------------------------------------------------*/
    public function fetchActiveProfileBoost($userID)
    {
        $currentTime = Carbon::now();

        return ProfileBoost::where('for_users__id', '=', $userID)
            ->where('expiry_at', '>=', $currentTime)
            ->orderBy('expiry_at', 'desc')
            ->first();
    }

    /**
     * fetch active profile boost user.
     *
     * @param array $userID
     *
     *-----------------------------------------------------------------------*/
    public function fetchAllProfileBoostUsers()
    {
        $currentTime = Carbon::now();

        //if data exist then show records else return blank array
        return ProfileBoost::where('for_users__id', '!=', getUserID())
            ->where('expiry_at', '>=', $currentTime)
            ->get();
    }

    /**
     * Fetch user subscription data by logged in user id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAllPremiumUsers()
    {
        $currentTime = Carbon::now();
        return UserSubscription::leftJoin(
            'user_profiles',
            'user_subscriptions.users__id',
            '=',
            'user_profiles.users__id'
        )
            ->select(
                __nestedKeyValues([
                    'user_subscriptions.*',
                    'user_profiles' => [
                        '_id AS user_profile_id',
                        '_uid AS user_profile_uid',
                        'profile_picture'
                    ]
                ])
            )
            ->where('user_subscriptions.expiry_at', '>=', $currentTime)
            ->where('user_subscriptions.users__id', '!=', getUserID())
            ->get();
    }

    
    /**
     * Fetch user subscription data by logged in user id.
     *
     * @param number $userID
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchPremiumUsers($userId)
    {
        $currentTime = Carbon::now();
        return UserSubscription::where('users__id', $userId)
            ->where('expiry_at', '>=', $currentTime)
            ->latest()
            ->first();
    }

    /**
     * Fetch all admin ids
     *
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAdminIds()
    {
        return UserModel::leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->where('user_authorities.user_roles__id', 1) // admin role id
            ->get()->pluck('_id')->toArray();
    }

    /**
     * Fetch all random feature users.
     *
     * @param number $ignoreUserIds, $acceptUserIds
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAllRandomFeatureUsers($ignoreUserIds=[], $acceptUserIds=[])
    {
        
        $qu = UserModel::leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_roles', 'user_authorities.user_roles__id', '=', 'user_roles._id')
            ->select(
                __nestedKeyValues([
                    'users' => [
                        '_id',
                        '_uid',
                        'status',
                        'username',
                        'created_at',
                        'updated_at',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as profileId',
                        'profile_picture',
                        'about_me',
                        'kanji_name'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    ''=> [
                        'title as role_name'
                    ]
                ])
            );

            if(!\__isEmpty($acceptUserIds)) {
                $qu = $qu->whereIn('users._id', $acceptUserIds) ;
            }

            if(!\__isEmpty($ignoreUserIds)) {
                $qu = $qu->whereNotIn('users._id', $ignoreUserIds) ;
            }
            
            $qu = $qu->where('users._id', '!=', getUserID())
            ->where('users.status', 1)
            ->get();
            return $qu;
    }

    public function fetchUserPhotoDataForLike(){

        $peopleLikeUserIds = $this->fetchUserLikeData(1)->pluck('to_users__id')->toArray();
        $peopleLikeUserIds[] = getUserID();
        return UserPhoto::leftJoin('users', 'user_photos.users__id', '=', 'users._id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('user_authorities', 'user_profiles.users__id', '=', 'user_authorities.users__id')
            ->leftJoin('user_roles', 'user_authorities.user_roles__id', '=', 'user_roles._id')
            //->leftJoin('user_feed', 'user_feed.photo__id', '=', 'user_photos._id')
            ->select(
                __nestedKeyValues([
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id as profileId',
                        'profile_picture',
                        'about_me',
                        'kanji_name'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'user_photos' => [
                        '_id as photo_id',
                        '_uid as photo_uid',
                        'file as image_name',
                        'updated_at as photoUpdatedAt',
                        'status as photo_status',
                        'comment as user_comment',
                        'created_at'
                    ],
                    // 'user_feed' => [
                    //     '_uid as user_feed_uid',
                    //     'updated_at as feedUpdatedAt',
                    //     'is_like',
                    //     'is_tagged',
                    //     'comment as feed_comment',
                    //     'users__id as feed_user_id'
                    // ],
                    'user_roles'=> [
                        'title as role_name'
                    ]
                ])
            )
            ->whereIn('user_photos.users__id',$peopleLikeUserIds)
            ->latest()
            //->get();
            ->paginate(configItem('paginate_count'));
    }

    public function fetchUserFeedData( $photo_id, $user_id = null ){
        if(!isset($user_id) or __isEmpty($user_id))
        {
            $user_id = getUserID();
        }
        return UserFeed::where('users__id', $user_id)->where('photo__id', $photo_id)->first();
    }

    public function fetchPhotoCommentData( $photo_id ){
        return UserPhotoComment::leftJoin('users', 'user_photo_comment.users__id', '=', 'users._id')
        ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
        ->select(
            __nestedKeyValues([
                'users' => [
                    '_id as userId',
                    '_uid as userUId',
                    'username',
                    DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                ],
                'user_profiles' => [
                    'profile_picture',
                    'kanji_name'
                ],
                'user_photo_comment' => [
                    'comment as user_comment',
                    'created_at as comment_date'
                ]               
            ])
        )
        ->where('photo__id', $photo_id)
        ->get();
    }

    /**
     * store booster user data.
     *
     * @param array $storeData
     *
     *-----------------------------------------------------------------------*/
    public function storeBooster($storeData)
    {
        //wallet transaction store data
        $keyValues = [
            'for_users__id',
            'expiry_at',
            'status',
            'credit_wallet_transactions__id'
        ];

        $boost = new ProfileBoost;
        // Check if user block added
        if ($boost->assignInputsAndSave($storeData, $keyValues)) {
            return $boost;
        }
        return false;
    }

    /**
     * Store user profile
     *
     * @param array $inputData
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function storeUserProfile($inputData)
    {
        $keyValues = [
            'users__id'     => $inputData['users__id'],
            'status'        => array_get($inputData, 'status'),
            'profile_picture'        => array_get($inputData, 'profile_picture'),
        ];

        $userrole = $inputData['user_roles__id'];
        if ($userrole == 2) {
            // partner role
            $keyValues['kanji_name'] = array_get($inputData, '');
            $keyValues['kata_name'] = array_get($inputData, '');
            $keyValues['dob'] = array_get($inputData, '');
            $keyValues['gender'] = array_get($inputData, '');
        }

        if ($userrole == 3) {
            // pt
            $keyValues['kanji_name'] = array_get($inputData, '');
            $keyValues['kata_name'] = array_get($inputData, '');
            $keyValues['dob'] = array_get($inputData, '');
            $keyValues['gender'] = array_get($inputData, '');
            $keyValues['do_qualify'] = array_get($inputData, '');
        }

        if ($userrole == 4 || $userrole == 5) {
            // gym , brand
            $keyValues['company_name'] = array_get($inputData, '');
            $keyValues['brand'] = array_get($inputData, '');
            $keyValues['do_start'] = array_get($inputData, '');
            $keyValues['website'] = array_get($inputData, '');
        }

        $userProfile = new UserProfile;
        // check if user profile stored successfully
        if ($userProfile->assignInputsAndSave($inputData, $keyValues)) {
            return $userProfile;
        }

        return false;
    }

    //store user time
    public function storeUserTime($inputData)
    {
        $user_time = [];
        $user_id = $inputData['user_id'];
        $mon_s = $inputData['mon_s'];
        $mon_e = $inputData['mon_e'];
        $item = [
            'day' => 'mon',
            'start' => $mon_s,
            'end' => $mon_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $tue_s = $inputData['tue_s'];
        $tue_e = $inputData['tue_e'];
        $item = [
            'day' => 'tue',
            'start' => $tue_s,
            'end' => $tue_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $wed_s = $inputData['wed_s'];
        $wed_e = $inputData['wed_e'];
        $item = [
            'day' => 'wed',
            'start' => $wed_s,
            'end' => $wed_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $thu_s = $inputData['thu_s'];
        $thu_e = $inputData['thu_e'];
        $item = [
            'day' => 'thu',
            'start' => $thu_s,
            'end' => $thu_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $fri_s = $inputData['fri_s'];
        $fri_e = $inputData['fri_e'];
        $item = [
            'day' => 'fri',
            'start' => $fri_s,
            'end' => $fri_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $sat_s = $inputData['sat_s'];
        $sat_e = $inputData['sat_e'];
        $item = [
            'day' => 'sat',
            'start' => $sat_s,
            'end' => $sat_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;

        $sun_s = $inputData['sun_s'];
        $sun_e = $inputData['sun_e'];
        $item = [
            'day' => 'sun',
            'start' => $sun_s,
            'end' => $sun_e,
            'users__id' => $user_id
        ];
        $user_time[] = $item;
        $keyValues = [];
        $u_time = new UserTime;
        // check if user profile stored successfully
        if ($u_time->prepareAndInsert($user_time)) {
            return $u_time;
        }
        return false;
    }

    //store user time
    public function updateUserTime($inputData)
    {
        $user_time = [];
        $user_id = $inputData['user_id'];
        $mon_s = $inputData['mon_s'];
        $mon_e = $inputData['mon_e'];
        $item = [
            'day' => 'mon',
            'start' => $mon_s,
            'end' => $mon_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'mon'
            ],
            $item
        );

        $tue_s = $inputData['tue_s'];
        $tue_e = $inputData['tue_e'];
        $item = [
            'day' => 'tue',
            'start' => $tue_s,
            'end' => $tue_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'tue'
            ],
            $item
        );
        
        $wed_s = $inputData['wed_s'];
        $wed_e = $inputData['wed_e'];
        $item = [
            'day' => 'wed',
            'start' => $wed_s,
            'end' => $wed_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'wed'
            ],
            $item
        );
        $thu_s = $inputData['thu_s'];
        $thu_e = $inputData['thu_e'];
        $item = [
            'day' => 'thu',
            'start' => $thu_s,
            'end' => $thu_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'thu'
            ],
            $item
        );
        $fri_s = $inputData['fri_s'];
        $fri_e = $inputData['fri_e'];
        $item = [
            'day' => 'fri',
            'start' => $fri_s,
            'end' => $fri_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'fri'
            ],
            $item
        );
        $sat_s = $inputData['sat_s'];
        $sat_e = $inputData['sat_e'];
        $item = [
            'day' => 'sat',
            'start' => $sat_s,
            'end' => $sat_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'sat'
            ],
            $item
        );
        $sun_s = $inputData['sun_s'];
        $sun_e = $inputData['sun_e'];
        $item = [
            'day' => 'sun',
            'start' => $sun_s,
            'end' => $sun_e,
            'users__id' => $user_id
        ];
        UserTime::updateOrCreate(
            [
                'users__id' => $user_id,
                'day' => 'sun'
            ],
            $item
        );
        
        return true;
    }

    public function getUserAvailability($user_id)
    {
        $ut = array();
        $mon = UserTime::where('users__id', $user_id)->where('day', 'mon')->first();

        if (__isEmpty($mon)) {
            $ut['mon_s'] = 0;
            $ut['mon_e'] = 0;
        } else {
            $ut['mon_s'] = $mon->start;
            $ut['mon_e'] = $mon->end;
        }
        $tue = UserTime::where('users__id', $user_id)->where('day', 'tue')->first();

        if (__isEmpty($tue)) {
            $ut['tue_s'] = 0;
            $ut['tue_e'] = 0;
        } else {
            $ut['tue_s'] = $tue->start;
            $ut['tue_e'] = $tue->end;
        }
        $mon = UserTime::where('users__id', $user_id)->where('day', 'wed')->first();

        if (__isEmpty($mon)) {
            $ut['wed_s'] = 0;
            $ut['wed_e'] = 0;
        } else {
            $ut['wed_s'] = $mon->start;
            $ut['wed_e'] = $mon->end;
        }
        $mon = UserTime::where('users__id', $user_id)->where('day', 'thu')->first();

        if (__isEmpty($mon)) {
            $ut['thu_s'] = 0;
            $ut['thu_e'] = 0;
        } else {
            $ut['thu_s'] = $mon->start;
            $ut['thu_e'] = $mon->end;
        }
        $mon = UserTime::where('users__id', $user_id)->where('day', 'fri')->first();

        if (__isEmpty($mon)) {
            $ut['fri_s'] = 0;
            $ut['fri_e'] = 0;
        } else {
            $ut['fri_s'] = $mon->start;
            $ut['fri_e'] = $mon->end;
        }
        $mon = UserTime::where('users__id', $user_id)->where('day', 'sat')->first();

        if (__isEmpty($mon)) {
            $ut['sat_s'] = 0;
            $ut['sat_e'] = 0;
        } else {
            $ut['sat_s'] = $mon->start;
            $ut['sat_e'] = $mon->end;
        }
        $mon = UserTime::where('users__id', $user_id)->where('day', 'sun')->first();

        if (__isEmpty($mon)) {
            $ut['sun_s'] = 0;
            $ut['sun_e'] = 0;
        } else {
            $ut['sun_s'] = $mon->start;
            $ut['sun_e'] = $mon->end;
        }

        return $ut;
    }
    // store user gym
    public function storeUserGym($inputData)
    {
        $user_gym = [];
        $item = [
            'users__id' => $inputData['users__id'],
            'countries__id' => $inputData['countries__id'],
            'name' => $inputData['name'],
            'latitude' => $inputData['latitude'],
            'longitude' => $inputData['longitude'],
        ];
        $user_gym[] = $item;
        $u_gym = new UserGym;
        // check if user profile stored successfully
        if ($u_gym->prepareAndInsert($user_gym)) {
            return $u_gym;
        }

        return false;
    }

    // store user gym list
    public function storeUserGymData($gym_id, $users__id)
    {
        $user_gym = [];
        $item = [
            'users__id' => $users__id,
            'gym_id' => $gym_id,
            'status' => 1
        ];
        $user_gym[] = $item;
        $u_gym = new UserGym;
        // check if user profile stored successfully
        if ($u_gym->prepareAndInsert($user_gym)) {
            return $u_gym;
        }
        return false;
    }
    

    // delete user gym list
    public function deleteUserGymData($users__id)
    {
        return UserGym::where('users__id', $users__id)
            ->delete();
    }

    // store user expertise list
    public function storeUserExpertiseData($expertise_id, $users__id)
    {
        $user_expertise = [];
        $item = [
            'users__id' => $users__id,
            'expertise_id' => $expertise_id,
            'status' => 1
        ];
        $user_expertise[] = $item;
        $u_expertise = new UserExpertise;
        // check if user profile stored successfully
        if ($u_expertise->prepareAndInsert($user_expertise)) {
            return $u_expertise;
        }
        return false;
    }

    // delete user expertise list
    public function deleteUserExpertiseData($users__id)
    {
        return UserExpertise::where('users__id', $users__id)
            ->delete();
    }

    // store user pricing session data
    public function storeOrUpdateUserSessionData($inputData, $users__id)
    {
        $user_pricing = [];
        $item = [
            'users__id' => $users__id,
            'session' => $inputData["session_type"],
            'price' => $inputData["price"],
            'status' => 1
        ];

        $session_item = $this->fetchUserSessionWithTypeData($inputData["session_type"], $users__id);
        if (__isEmpty($session_item)) {
            $u_pricing = new UserPricing;
            $user_pricing[] = $item;
            // check if user profile stored successfully
            if ($u_pricing->prepareAndInsert($user_pricing)) {
                return $u_pricing;
            }
        } else {
            // Check if information updated
            if ($session_item->modelUpdate(["price" => $inputData["price"]])) {
                return true;
            }
        }
        return false;
    }

    public function deleteUserPricingData($item_uid) {
        return UserPricing::where('_uid', $item_uid)
            ->delete();
    }

    /**
     * Update User Profile
     *
     * @param object $userProfile
     * @param array $updateData
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function updateProfile($userProfile, $updateData)
    {
        if ($userProfile->modelUpdate($updateData)) {
            return true;
        }
        return false;
    }

    /**
     * Delete User
     *
     * @param object $user
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function deleteUser($user)
    {
        if ($user->delete()) {
            return true;
        }
        return false;
    }
}
