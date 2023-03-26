<?php
/**
* ManageReviewRepository.php - Repository file
*
* This file is part of the Review component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Review\Repositories;

use Auth;
use DB;
use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\Review\Models\ReviewModel;

class ManageReviewRepository extends BaseRepository
{
    /**
     * Constructor.
     *
     * @param Page $review - review Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch all review list.
     *
     * @return object
     *---------------------------------------------------------------- */
    public function fetchListData($status)
    {
        return ReviewModel::leftJoin('users', 'user_reviews.to_users__id', '=', 'users._id')
            ->select(
                __nestedKeyValues([
                    'user_reviews.*',
                    'users' => [
                        '_id as userId',
                        'username as reviewed_user_username',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS reviewedUserName')
                    ]
                ])
            )
            ->where('user_reviews.status', $status)
            ->groupBy('user_reviews.to_users__id')
            ->get();
    }

    /**
     * fetch all report list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchReview($userIds)
    {
        return ReviewModel::where('to_users__id', $userIds)
            ->where('by_users__id', getUserID())
            ->first();
    }

    /**
     * fetch all report list.
     *
     * @return array|object
     *---------------------------------------------------------------- */
    public function fetchReviewByUser($userIds)
    {
        
        return ReviewModel::join('users', 'user_reviews.by_users__id', '=', 'users._id')
            ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
            ->leftJoin('user_profiles', 'users._id', '=', 'user_profiles.users__id')
            ->leftJoin('countries', 'user_profiles.countries__id', '=', 'countries._id')
            ->leftJoin('user_roles', 'user_authorities.user_roles__id', '=', 'user_roles._id')
            ->whereIn('user_reviews.to_users__id', $userIds)
            ->select(
                __nestedKeyValues([
                    'user_reviews' => [
                        '_id',
                        'created_at',
                        'updated_at',
                        'status',
                        'to_users__id',
                        'by_users__id',
                        'rate_value',
                        'review_comment'
                    ],
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username as reviewed_by_user_username',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS reviewedByUser')
                    ],
                    'user_profiles' => [
                        '_id as userProfileId',
                        'profile_picture',
                        'countries__id',
                        'gender',
                        'dob',
                        'kanji_name'
                    ],
                    'countries' => [
                        'name as countryName'
                    ],
                    'user_authorities' => [
                        'updated_at as userAuthorityUpdatedAt'
                    ],
                    'user_roles' => [
                        'title as userRoleName'
                    ]
                ])
            )
            ->get();
    }

    /**
     * Fetch the record of review user data
     *
     * @param  int || string $email
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchReviewByMeUser($byUserId)
    {
        return ReviewModel::where('to_users__id', $byUserId)
            ->where('by_users__id', getUserID())
            ->first();
    }

    /**
     * fetch review data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return ReviewModel::where('_id', $idOrUid)->first();
        } else {
            return ReviewModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * Store Abuse Report.
     *
     * @param array $storeData
     * 
     *-----------------------------------------------------------------------*/
    public function storeReviewUser($storeData)
    {
        $keyValues = [
            'status',
            'to_users__id',
            'by_users__id',
            'rate_value',
            'review_comment'
        ];

        // Get Instance of Abuse Report model
        $reviewModel = new ReviewModel;

        // Store Abuse User Report
        if ($reviewModel->assignInputsAndSave($storeData, $keyValues)) {
            return true;
        }
        return false;
    }

    /**
     * Update moderate review Data
     *
     * @param object $page
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function batchUpdate($updateData)
    {
        $reviewModel = new ReviewModel;

        // Check if information updated
        if ($reviewModel->batchUpdate($updateData, '_id')) {
            $user = Auth::user();
            $userName = $user->first_name . ' ' . $user->last_name;
            activityLog('Review Moderated by ' . $userName);
            return true;
        }
        return false;
    }

    public function fetchTotalRateUser($userId) {
        return ReviewModel::where('to_users__id', $userId)
            ->avg( 'rate_value' )
            ;
    }
}
