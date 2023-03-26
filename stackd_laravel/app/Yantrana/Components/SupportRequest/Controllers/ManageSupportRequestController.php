<?php
/**
* ManageSupportRequestController.php - Controller file
*
* This file is part of the SupportRequest component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\SupportRequest\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\SupportRequest\CommonPostRequest;
use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\SupportRequest\ManageSupportRequestEngine;
use App\Yantrana\Components\SupportRequest\Requests\{ManageSupportRequestAddRequest, ManageSupportRequestEditRequest};
use Carbon\Carbon;

class ManageSupportRequestController extends BaseController
{
    /**
     * @var ManageSupportRequestEngine - ManageSupportRequest Engine
     */
    protected $manageSupportRequestEngine;

    /**
     * Constructor.
     *
     * @param ManageSupportRequestEngine $manageSupportRequestEngine - ManageSupportRequest Engine
     *-----------------------------------------------------------------------*/
    public function __construct(ManageSupportRequestEngine $manageSupportRequestEngine)
    {
        $this->manageSupportRequestEngine = $manageSupportRequestEngine;
    }

    /**
     * Show Support List View.
     *
     *-----------------------------------------------------------------------*/
    public function supportListView()
    {
        return $this->loadManageView('support.manage.list');
    }

    /**
     * Get Datatable data.
     *
     *-----------------------------------------------------------------------*/
    public function getDatatableData()
    {
        return $this->manageSupportRequestEngine->prepareSupportList();
    }

    /**
     * Show Support Add View.
     *
     *-----------------------------------------------------------------------*/
    public function supportAddView()
    {
        return $this->loadManageView('support.manage.add');
    }

    /**
     * Handle add new Support request.
     *
     * @param ManageSupportRequestAddRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processAddSupport(ManageSupportRequestAddRequest $request)
    {
        $processReaction = $this->manageSupportRequestEngine
            ->prepareForAddNewSupport($request->all());

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.support.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Show Support Edit View.
     *
     *-----------------------------------------------------------------------*/
    public function supportEditView($supportUId)
    {
        $processReaction = $this->manageSupportRequestEngine->prepareUpdateData($supportUId);

        return $this->loadManageView('support.manage.edit', $processReaction['data']);
    }

    /**
     * Handle edit new Support request.
     *
     * @param ManageSupportRequestEditRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processEditSupport(ManageSupportRequestEditRequest $request, $supportUId)
    {
        $processReaction = $this->manageSupportRequestEngine
            ->prepareForEditNewSupport($request->all(), $supportUId);

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.support.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Handle delete Support data request.
     *
     * @param int $supportUId
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function delete($supportUId)
    {
        $processReaction = $this->manageSupportRequestEngine->processDelete($supportUId);

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
