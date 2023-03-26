<?php
/**
* NotificationController.php - Controller file
*
* This file is part of the Notification component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Notification\Controllers;

use App\Yantrana\Support\CommonPostRequest;
use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Notification\NotificationEngine;
use App\Yantrana\Support\CommonUnsecuredPostRequest;

class NotificationController extends BaseController
{
    /**
     * @var NotificationEngine - Notification Engine
     */
    protected $notificationEngine;

    /**
     * Constructor.
     *
     * @param NotificationEngine $notificationEngine - Notification Engine
     *-----------------------------------------------------------------------*/
    public function __construct(NotificationEngine $notificationEngine)
    {
        $this->notificationEngine = $notificationEngine;
    }

    /**
     * Get notification view.
     *
     * 
     * @return json object
     *---------------------------------------------------------------- */
    public function getNotificationView(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->notificationEngine->prepareNotificationListData($request->all());
        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('notification.notification-listdata', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('notification.notification-list', $processReaction['data']);
        }
    }

    /**
     * Get Notification DataTable data.
     *
     *-----------------------------------------------------------------------*/
    public function getNotificationList()
    {
        return $this->notificationEngine->prepareNotificationList();
    }

    /**
     * Handle read all notification request.
     *
     * @param object read notification $request
     * @param string $reminderToken
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function readAllNotification()
    {
        $processReaction = $this->notificationEngine->processReadAllNotification();

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
