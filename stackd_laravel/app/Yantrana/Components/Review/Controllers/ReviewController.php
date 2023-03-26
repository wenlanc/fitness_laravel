<?php
/**
* ReviewController.php - Controller file
*
* This file is part of the Abuse Report component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Review\Controllers;

use App\Yantrana\Base\BaseController;
use App\Yantrana\Components\Review\ManageReviewEngine;
use App\Yantrana\Components\Review\Requests\{ModerateReviewRequest};

class ReviewController extends BaseController
{
    /**
     * @var ManageReviewEngine - ManageReview Engine
     */
    protected $manageReviewEngine;

    /**
     * Constructor.
     *
     * @param ManageReviewEngine $manageReviewEngine - ManageReport Engine
     *-----------------------------------------------------------------------*/
    public function __construct(ManageReviewEngine $manageReviewEngine)
    {
        $this->manageReviewEngine = $manageReviewEngine;
    }

    /**
     * Show review List View.
     *
     *-----------------------------------------------------------------------*/
    public function reviewListView($status)
    {
        $processReaction = $this->manageReviewEngine->prepareReviewList($status);

        return $this->loadManageView('review.manage.list', $processReaction['data']);
    }

    /**
     * Handle moderate review request.
     *
     * @param ModerateReviewRequest $request
     *
     * @return json response
     *---------------------------------------------------------------- */
    public function reviewModerated(ModerateReviewRequest $request)
    {
        $processReaction = $this->manageReviewEngine
            ->processModerateReview($request->all());

        return $this->responseAction(
            $this->processResponse($processReaction, [], [], true)
        );
    }
}
