<?php
/**
* ManagePricingTypeController.php - Controller file
*
* This file is part of the PricingType component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\PricingType\Controllers;

use Illuminate\Http\Request;
use App\Yantrana\Support\CommonPostRequest;
use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\PricingType\ManagePricingTypeEngine;
use App\Yantrana\Components\PricingType\Requests\{ManagePricingTypeAddRequest, ManagePricingTypeEditRequest};
use Carbon\Carbon;

class ManagePricingTypeController extends BaseController
{
    /**
     * @var ManagePricingTypeEngine - ManagePricingType Engine
     */
    protected $managePricingTypeEngine;

    /**
     * Constructor.
     *
     * @param ManagePricingTypeEngine $managePricingTypeEngine - ManagePricingType Engine
     *-----------------------------------------------------------------------*/
    public function __construct(ManagePricingTypeEngine $managePricingTypeEngine)
    {
        $this->managePricingTypeEngine = $managePricingTypeEngine;
    }

    /**
     * Show PricingType List View.
     *
     *-----------------------------------------------------------------------*/
    public function PricingTypeListView()
    {
        return $this->loadManageView('pricingtype.manage.list');
    }

    /**
     * Get Datatable data.
     *
     *-----------------------------------------------------------------------*/
    public function getDatatableData()
    {
        return $this->managePricingTypeEngine->preparePricingTypeList();
    }

    /**
     * Show PricingType Add View.
     *
     *-----------------------------------------------------------------------*/
    public function pricingtypeAddView()
    {
        return $this->loadManageView('pricingtype.manage.add');
    }

    /**
     * Handle add new PricingType request.
     *
     * @param ManagePricingTypeAddRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processAddPricingType(ManagePricingTypeAddRequest $request)
    {
        $processReaction = $this->managePricingTypeEngine
            ->prepareForAddNewPricingType($request->all());

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.pricingtype.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Show PricingType Edit View.
     *
     *-----------------------------------------------------------------------*/
    public function pricingtypeEditView($pricingtypeUId)
    {
        $processReaction = $this->managePricingTypeEngine->prepareUpdateData($pricingtypeUId);

        return $this->loadManageView('pricingtype.manage.edit', $processReaction['data']);
    }

    /**
     * Handle edit new PricingType request.
     *
     * @param ManagePricingTypeEditRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function processEditPricingType(ManagePricingTypeEditRequest $request, $pricingtypeUId)
    {
        $processReaction = $this->managePricingTypeEngine
            ->prepareForEditNewPricingType($request->all(), $pricingtypeUId);

        //check reaction code equal to 1
        if ($processReaction['reaction_code'] === 1) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->redirectTo('manage.pricingtype.view')
            );
        } else {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true)
            );
        }
    }

    /**
     * Handle delete PricingType data request.
     *
     * @param int $pricingtypeUId
     *
     * @return json object
     *---------------------------------------------------------------- */
    public function delete($pricingtypeUId)
    {
        $processReaction = $this->managePricingTypeEngine->processDelete($pricingtypeUId);

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
