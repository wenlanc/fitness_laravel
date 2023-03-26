<?php
/**
* NotificationRepository.php - Repository file
*
* This file is part of the Notification component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Notification\Repositories;

use DB;
use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\Notification\Models\NotificationModel;

class NotificationRepository extends BaseRepository
{
    /**
     * Constructor.
     *
     * @param Page $page - page Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch notificationModel data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return NotificationModel::where('_id', $idOrUid)->first();
        } else {
            return NotificationModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * fetch all un read notification data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetchAllUnReadNotification()
    {
        //check is numeric
        return NotificationModel::where('is_read', null)->where('users__id', getUserID())->latest()->get();
    }

    /**
     * fetch all pages list for datatable.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchNotificationListDTData()
    {
        $dataTableConfig = [
            'searchable' => []
        ];

        return NotificationModel::where('notifications.users__id', getUserID())
            ->latest()
            ->dataTables($dataTableConfig)
            ->toArray();
    }

    /**
     * fetch all pages list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchNotificationListData()
    {
        return NotificationModel::leftJoin('users','notifications.by_users__id','users._id')
            ->leftJoin(
                'user_profiles',
                'users._id',
                '=',
                'user_profiles.users__id'
            )
            ->select(
                __nestedKeyValues([
                    'notifications.*',
                    'users' => [
                        '_id as userId',
                        '_uid as userUId',
                        'username',
                        DB::raw('CONCAT(users.first_name, " ", users.last_name) AS userFullName')
                    ],
                    'user_profiles' => [
                        '_id AS user_profile_id',
                        '_uid AS user_profile_uid',
                        'kanji_name',
                        'profile_picture'
                    ]
                ])
            )
            ->where('notifications.users__id', getUserID())
            ->latest()
            ->paginate(configItem('paginate_count'));;
    }

    /**
     * fetch all api notification list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchApiNotificationListData()
    {
        $dataTableConfig = [
            'searchable' => []
        ];

        return NotificationModel::where('notifications.users__id', getUserID())
            ->latest()
            ->customTableOptions($dataTableConfig);
    }

    /**
     * Update Notification data
     *
     * @param object $notificationData
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updateNotification($notificationData)
    {
        // Check if information updated
        if ($notificationData->modelUpdate(['is_read' => 1])) {
            return true;
        }
        return false;
    }

    /**
     * Update All Notification data
     *
     * @param array $notificationData
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updateAllNotification($notificationData)
    {
        //$notificationModel = new NotificationModel;
        // Check if information updated
        if (NotificationModel::bunchInsertUpdate($notificationData, '_id')) {
            return true;
        }
        return false;
    }
}
