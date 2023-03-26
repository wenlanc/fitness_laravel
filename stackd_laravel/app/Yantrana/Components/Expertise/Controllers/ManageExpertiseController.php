<?php
/**
* ManageExpertiseController.php - Controller file
*
* This file is part of the Expertise component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Expertise\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\Support\CommonPostRequest;
use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Expertise\ManageExpertiseEngine;
use App\Yantrana\Components\Expertise\Requests\{ManageExpertiseAddRequest, ManageExpertiseEditRequest};
use Carbon\Carbon;

class ManageExpertiseController extends BaseController
{
    /**
     * @var ManageExpertiseEngine - ManageExpertise Engine
     */
    protected $manageExpertiseEngine;

    /**
     * Constructor.
     *
     * @param ManageExpertiseEngine $manageExpertiseEngine - ManageExpertise Engine
     *-----------------------------------------------------------------------*/
    public function __construct(ManageExpertiseEngine $manageExpertiseEngine)
    {
        $this->manageExpertiseEngine = $manageExpertiseEngine;
    }

    /**
     * Show expertise List View.
     *
     *-----------------------------------------------------------------------*/
    public function expertiseListView()
    {
        return $this->loadManageView('expertise.manage.list');
    }

    /**
     * Get Datatable data.
     *
     *-----------------------------------------------------------------------*/
    public function getDatatableData()
    {
        return $this->manageExpertiseEngine->prepareExpertiseList();
    }

    /**
     * Show expertise Add View.
     *
     *-----------------------------------------------------------------------*/
    public function expertiseAddView()
    {
        return $this->loadManageView('expertise.manage.add');
    }

    /**
     * Handle add new expertise request.
     *
     * @param ManageExpertiseAddRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processAddExpertise(ManageExpertiseAddRequest $request)
    {
        $processReaction = $this->manageExpertiseEngine
            ->prepareForAddNewExpertise($request->all());

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.expertise.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Show expertise Edit View.
     *
     *-----------------------------------------------------------------------*/
    public function expertiseEditView($expertiseUId)
    {
        $processReaction = $this->manageExpertiseEngine->prepareUpdateData($expertiseUId);

        return $this->loadManageView('expertise.manage.edit', $processReaction['data']);
    }

    /**
     * Handle edit new expertise request.
     *
     * @param ManageExpertiseEditRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processEditExpertise(ManageExpertiseEditRequest $request, $expertiseUId)
    {
        $processReaction = $this->manageExpertiseEngine
            ->prepareForEditNewExpertise($request->all(), $expertiseUId);

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.expertise.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Handle delete expertise data request.
     *
     * @param int $expertiseUId
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function delete($expertiseUId)
    {
        $processReaction = $this->manageExpertiseEngine->processDelete($expertiseUId);

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
