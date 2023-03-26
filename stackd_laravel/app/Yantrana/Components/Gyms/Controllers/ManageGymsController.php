<?php
/**
* ManageGymsController.php - Controller file
*
* This file is part of the Pages component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Controllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Gyms\ManageGymsEngine;
use App\Yantrana\Components\Gyms\Requests\{GymsAddRequest, GymsEditRequest};

class ManageGymsController extends BaseController
{
    /**
     * @var ManageGymsEngine - ManageGyms Engine
     */
    protected $manageGymsEngine;

    /**
     * Constructor.
     *
     * @param ManageGymsEngine $ManageGymsEngine - ManageGyms Engine
     *-----------------------------------------------------------------------*/
    public function __construct(ManageGymsEngine $manageGymsEngine)
    {
        $this->manageGymsEngine = $manageGymsEngine;
    }

    /**
     * Show Gyms List View.
     *
     *-----------------------------------------------------------------------*/
    public function gymsListView()
    {
        $processReaction = $this->manageGymsEngine->prepareGymsList();

        return $this->loadManageView('gyms.manage.list', $processReaction['data']);
    }

    /**
     * Show Gyms Add View.
     *
     *-----------------------------------------------------------------------*/
    public function gymsAddView()
    {
        return $this->loadManageView('gyms.manage.add');
    }

    /**
     * Handle add new page request.
     *
     * @param gymsAddRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function addGyms(GymsAddRequest $request)
    {
        $processReaction = $this->manageGymsEngine
            ->processAddNewGyms($request->all());

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.gyms.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Show Gyms Edit View.
     *
     *-----------------------------------------------------------------------*/
    public function gymsEditView($gymsUId)
    {
        $processReaction = $this->manageGymsEngine->prepareGymsUpdateData($gymsUId);

        return $this->loadManageView('gyms.manage.edit', $processReaction['data']);
    }

    /**
     * Handle edit new Gyms request.
     *
     * @param GymsEditRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function editGyms(GymsEditRequest $request, $gymsUId)
    {
        $processReaction = $this->manageGymsEngine
            ->processEditGyms($request->all(), $gymsUId);

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.gyms.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Handle delete Gyms data request.
     *
     * @param int $gymsUId
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function deleteGyms($gymsUId)
    {
        $processReaction = $this->manageGymsEngine->processDeleteGyms($gymsUId);

        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.gyms.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }

    }
}
