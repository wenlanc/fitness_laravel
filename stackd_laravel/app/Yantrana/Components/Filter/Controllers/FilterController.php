<?php
/**
* FilterController.php - Controller file
*
* This file is part of the Filter component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Filter\Controllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Filter\FilterEngine;
use App\Yantrana\Support\CommonUnsecuredPostRequest;

class FilterController extends BaseController
{
    /**
     * @var  FilterEngine $filterEngine - Filter Engine
     */
    protected $filterEngine;

    /**
     * Constructor
     *
     * @param  FilterEngine $filterEngine - Filter Engine
     *
     * @return  void
     *-----------------------------------------------------------------------*/

    function __construct(FilterEngine $filterEngine)
    {
        $this->filterEngine = $filterEngine;
    }

    /**
     * Get Filter data and show filter view
     *
     * @param obj CommonUnsecuredPostRequest $request
     * 
     * return view
     *-----------------------------------------------------------------------*/
    public function getFindMatches(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterDataDistance($request->all(), true);

        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.find-matches', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.filter', $processReaction['data']);
        }
    }

    public function getFindPT(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterDataPTDistance($request->all(), true);

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true),
            $this->replaceView('filter.ajax.find-pt', $processReaction['data'])
        );

        // if ($request->ajax()) {
        //     return $this->responseAction(
        //         $this->processResponse($processReaction, [], [], true),
        //         $this->replaceView('filter.find-matches-pt', $processReaction['data'])
        //     );
        // } else {
        //     return $this->loadPublicView('filter.filter', $processReaction['data']);
        // }
    }

    public function getMatchesList(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterMatchData($request->all(),true);
        $profileVisitorCount = $this->filterEngine->fetchProfileVisitorCount();
        $processReaction['data']['profileVisitorCount'] = $profileVisitorCount;
        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.matched_list', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.match_list', $processReaction['data']);
        }
    }

    public function getPendingList(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterPendingData($request->all(),true);

        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.pending_list', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.match_list', $processReaction['data']);
        }
    }
    public function getVisitorList(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterVisitorData($request->all(), true);

        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.visitor_list', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.match_list', $processReaction['data']);
        }
    }
    public function getBlockedList(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterBlockData($request->all(),true);

        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.blocked_list', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.blocked_list', $processReaction['data']);
        }
    }

    public function getPtList(CommonUnsecuredPostRequest $request)
    {
        $processReaction = $this->filterEngine->processFilterDataPTFollow($request->all(),true);

        if ($request->ajax()) {
            return $this->responseAction(
                $this->processResponse($processReaction, [], [], true),
                $this->replaceView('filter.ajax.pt_list', $processReaction['data'])
            );
        } else {
            return $this->loadPublicView('filter.pt_list', $processReaction['data']);
        }
    }
}
