<?php
/**
* ManageReviewEngine.php - Main component file
*
* This file is part of the Pages component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Review;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Review\Repositories\ManageReviewRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;

class ManageReviewEngine extends BaseEngine
{
    /**
     * @var ManageReviewRepository - ManageReview Repository
     */
    protected $manageReviewRepository;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * Constructor.
     *
     * @param ManageReviewRepository $ManageReviewRepository - ManageReview Repository
     *-----------------------------------------------------------------------*/
    public function __construct(ManageReviewRepository $manageReviewRepository, UserRepository $userRepository)
    {
        $this->manageReviewRepository     = $manageReviewRepository;
        $this->userRepository               = $userRepository;
    }

    /**
     * get Review list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareReviewList($status)
    {
        //get Review list collection
        $reviewCollection = $this->manageReviewRepository->fetchListData($status);

        $reviewListData = [];
        if (!__isEmpty($reviewCollection)) {
            //pluck for user ids
            $forUserIds = $reviewCollection->pluck('to_users__id')->toArray();

            //fetch Review by users
            $reviewedByUser = $this->manageReviewRepository->fetchReviewByUser($forUserIds);
            $reviewedUserCollection = $reviewedByUser->collect()->groupBy('to_users__id');

            $reviewedUserData = [];
            $count = [];
            //collect Review data in array
            foreach ($reviewedUserCollection as $reviewUserKey => $reviewByUser) {
                $count[$reviewUserKey] = $reviewByUser->count();
                //check is not empty array
                if (!__isEmpty($reviewByUser)) {
                    foreach ($reviewByUser as $key => $user) {
                        $reviewedUserData[$reviewUserKey][] = [
                            "_id"                 => $user['_id'],
                            "created_at"         => formatDate($user['created_at']),
                            "updated_at"         => formatDate($user['updated_at']),
                            "status"             => $user['status'],
                            "to_users__id"       => $user['to_users__id'],
                            "by_users__id"       => $user['by_users__id'],
                            "rate_value"         => $user['rate_value'],
                            "review_comment"     => $user['review_comment'],
                            "userId"             => $user['userId'],
                            "reviewedByUser"     => $user['kanji_name'], //$user['reviewedByUser'],
                            "kanji_name"     => $user['kanji_name'],
                            // 'Reviewed_by_user_profile_link' 	=> $user['reviewed_by_user_username'],
                            'reviewed_by_user_profile_url' => route('user.profile_view', ['username' => $user['reviewed_by_user_username']])
                        ];
                    }
                }
            }

            //collect Review data in array
            foreach ($reviewCollection as $key => $review) {
                $reviewListData[] = [
                    '_id'                 => $review['_id'],
                    '_uid'                 => $review['_uid'],
                    'reviewed_user'     => $review['kanji_name'], // $review['reviewedByUser']
                    'total_review_count' => $count[$review->to_users__id],
                    'reviewedByUser'    => $reviewedUserData[$review->to_users__id],
                    'for_users__id'        => $review->to_users__id,
                    'created_at'         => formatDate($review['created_at']),
                    'updated_at'         => formatDate($review['updated_at']),
                    'status'             => $review['status'],
                    'formattedStatus'     => configItem('review_user_status_codes', $review['status']),
                    "rate_value" => $user['rate_value'],
                    "review_comment" => $user['review_comment'],
                    'reviewed_by_user_username'     => $review['reviewed_by_user_username'],
                ];
            }
        }

        return $this->engineReaction(1, [
            'reviewListData' => $reviewListData
        ]);
    }

    /**
     * process moderate user Review.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function processModerateReview($inputData)
    {
        $reviewCollection = $this->manageReviewRepository->fetchReviewByUser([$inputData['forUserId']]);

        //if is empty then show error message
        if (__isEmpty($reviewCollection)) {
            return $this->engineReaction(1, null, __tr('Review does not exist'));
        }

        $updateData = [];
        // check if not empty
        if (!__isEmpty($reviewCollection)) {
            foreach ($reviewCollection as $key => $reviewData) {
                //update data
                $updateData[] = [
                    '_id'                => $reviewData['_id'],
                    'to_users__id'        => $reviewData['to_users__id'],
                    'rate_value' => $inputData['rate_value'],
                    'review_comment' => $inputData['review_comment'],
                    //'status'             => $inputData['ReviewStatus'],
                    //'moderated_by_users__id' => getUserID()
                ];
            }
        }

        //Check if Review updated
        if ($this->manageReviewRepository->batchUpdate($updateData)) {
            //check user block Review is accepted
            if ($inputData['ReviewStatus'] == 2 || $inputData['ReviewStatus'] == 3) {
                //fetch user
                $user = $this->userRepository->fetch($inputData['forUserId']);

                if ($user->user_role_id == 1) { // if admin user
                    return $this->engineReaction(2, null, __tr('Admin cannot moderated'));
                }

                //collect update data
                $updateData = [
                    'status' => (isset($inputData['ReviewStatus']) and $inputData['ReviewStatus'] == 2) ? 3 : 1, // block
                    'block_reason' => 'Abuse Review by admin'
                ];

                // Check if user activated successfully
                if ($this->userRepository->updateUser($user, $updateData)) {
                    return $this->engineReaction(1, null, __tr('Review moderated successfully'));
                }
            } else {
                return $this->engineReaction(1, null, __tr('Review moderated successfully'));
            }
        }

        return $this->engineReaction(2, null, __tr('Review not moderated.'));
    }
}
