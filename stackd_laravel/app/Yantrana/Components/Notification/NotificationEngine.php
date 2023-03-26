<?php
/**
* NotificationEngine.php - Main component file
*
* This file is part of the Notification component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Notification;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Notification\Repositories\NotificationRepository;

class NotificationEngine extends BaseEngine
{
    /**
     * @var NotificationRepository - Notification Repository
     */
    protected $notificationRepository;

    /**
     * Constructor.
     *
     * @param NotificationRepository $notificationRepository - ManagePages Repository
     *-----------------------------------------------------------------------*/
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * get notification list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareNotificationList()
    {
        $notificationCollection = $this->notificationRepository->fetchNotificationListDTData();

        $requireColumns = [
            '_id',
            '_uid',
            'created_at' => function ($pageData) {
                return formatDate($pageData['created_at']);
            },
            'formattedCreatedAt' => function ($pageData) {
                return formatDiffForHumans($pageData['created_at']);
            },
            'is_read',
            'action',
            'formattedIsRead' => function ($key) {
                return (isset($key['is_read']) and $key['is_read'] == 1) ? 'Yes' : 'No';
            },
            'message'
        ];

        return $this->dataTableResponse($notificationCollection, $requireColumns);
    }

    public function prepareNotificationListData()
    {
        $notificationCollection = $this->notificationRepository->fetchNotificationListData();
        $notificationData = [];
        //check if not empty collection
        if (!__isEmpty($notificationCollection)) {
            foreach ($notificationCollection as $key => $notification) {
                $userImageUrl = '';
                //check is not empty
                if (!__isEmpty($notification->profile_picture)) {
                    $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $notification->userUId]);
                    $userImageUrl = getMediaUrl($profileImageFolderPath, $notification->profile_picture);
                } else {
                    $userImageUrl = noThumbImageURL();
                }

                $notificationData[] = [
                    '_id'   => $notification->_id,
                    '_uid'   => $notification->_uid,
                    'message'   => $notification->message,
                    'action'    => $notification->action,
                    'is_read'    => $notification->is_read,
                    'users__id'    => $notification->users__id,
                    'status'      => $notification->status,
                    'created_at'  => formatDiffForHumans($notification->created_at),
                    'userFullName' => $notification->userFullName,
                    'username' => $notification->username,
                    'kanji_name' => $notification->kanji_name,
                    'userImageUrl' => $userImageUrl,
                    'profilePicture' => $notification->profile_picture,
                ];
            }
        }

        // Updating as read 1
        $notification = $this->notificationRepository->fetchAllUnReadNotification();
        $notificationData1 = [];
        if (!__isEmpty($notification)) {
            foreach ($notification as $key => $notify) {
                $notificationData1[] = [
                    '_id'         => $notify->_id,
                    'is_read'     => 1
                ];
            }
        }
        if (!__isEmpty($notification)) {
            if ($this->notificationRepository->updateAllNotification($notificationData1)) {
            }
        }
    

        return $this->engineReaction(1, [
            'notificationData'      => $notificationData,
            'nextPageUrl'           => $notificationCollection->nextPageUrl(),
            'hasMorePages'          => $notificationCollection->hasMorePages(),
            'totalCount'            => $notificationCollection->total()
        ]);
    }

    /**
     * get Api notification list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareApiNotificationList()
    {
        $notificationCollection = $this->notificationRepository->fetchApiNotificationListData();

        $requireColumns = [
            '_id',
            '_uid',
            'created_at' => function ($pageData) {
                return formatDate($pageData['created_at']);
            },
            'formattedCreatedAt' => function ($pageData) {
                return formatDiffForHumans($pageData['created_at']);
            },
            'is_read',
            'action',
            'formattedIsRead' => function ($key) {
                return (isset($key['is_read']) and $key['is_read'] == 1) ? 'Yes' : 'No';
            },
            'message'
        ];


        return $this->customTableResponse($notificationCollection, $requireColumns);
    }

    /**
     * Process Read All Notification.
     *
     *-----------------------------------------------------------------------*/
    public function processReadAllNotification()
    {
        $notification = $this->notificationRepository->fetchAllUnReadNotification();

        //if notification not exists
        if (__isEmpty($notification)) {
            return $this->engineReaction(2, null, __tr('Notification does not exists.'));
        }

        //all notification ids
        //$notificationIds = $notification->pluck('_id')->toArray();
        $notificationData = [];
        if (!__isEmpty($notification)) {
            foreach ($notification as $key => $notify) {
                $notificationData[] = [
                    '_id'         => $notify->_id,
                    'is_read'     => 1
                ];
            }
        }

        //update notification
        if ($this->notificationRepository->updateAllNotification($notificationData)) {
            return $this->engineReaction(1, null, __tr('Notification read successfully.'));
        }
        //error response
        return $this->engineReaction(2, null, __tr('Notification not read.'));
    }

    /**
     * Prepare Notification data.
     *
     *-----------------------------------------------------------------------*/
    public function prepareNotificationData()
    {
        return $this->engineReaction(1, getNotificationList());
    }
}
