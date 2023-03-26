<?php
/**
* ManageExpertiseEngine.php - Main component file
*
* This file is part of the Expertise component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Expertise;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Expertise\Repositories\ManageExpertiseRepository;

class ManageExpertiseEngine extends BaseEngine
{
    /**
     * @var ManageExpertiseRepository - ManageExpertise Repository
     */
    protected $manageExpertiseRepository;

    /**
     * Constructor.
     *
     * @param ManageExpertiseRepository $manageExpertiseRepository - ManageExpertise Repository
     *-----------------------------------------------------------------------*/
    public function __construct(ManageExpertiseRepository $manageExpertiseRepository)
    {
        $this->manageExpertiseRepository = $manageExpertiseRepository;
    }

    /**
     * get expertise list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareExpertiseList()
    {
        $expertiseCollection = $this->manageExpertiseRepository->fetchListData();

        $requireColumns = [
            '_id',
            '_uid',
            'title',
            'created_at' => function ($expertiseData) {
                return formatDate($expertiseData['created_at']);
            },
            'updated_at' => function ($expertiseData) {
                return formatDate($expertiseData['updated_at']);
            },
            'status' => function ($expertiseData) {
                return configItem('status_codes', $expertiseData['status']);
            },
        ];

        return $this->dataTableResponse($expertiseCollection, $requireColumns);
    }

    /**
     * Process add new expertise.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForAddNewExpertise($inputData)
    {
        $storeData = [
            'title'         => $inputData['title'],
            'description'         => $inputData['description'],
            'status'        => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2,
        ];

        //Check if expertise added
        if ($this->manageExpertiseRepository->store($storeData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Expertise added successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Expertise not added.'));
    }

    /**
     * get expertise edit data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareUpdateData($expertiseUId)
    {
        $expertiseCollection = $this->manageExpertiseRepository->fetch($expertiseUId);

        //if is empty
        if (__isEmpty($expertiseCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Expertise does not exist'));
        }

        $expertiseEditData = [];
        if (!__isEmpty($expertiseCollection)) {
            $expertiseEditData = [
                '_id'             => $expertiseCollection['_id'],
                '_uid'             => $expertiseCollection['_uid'],
                'title'         => $expertiseCollection['title'],
                'description'     => $expertiseCollection['description'],
                'created_at'     => formatDate($expertiseCollection['created_at']),
                'updated_at'     => formatDate($expertiseCollection['updated_at']),
                'status'         => $expertiseCollection['status'],
            ];
        }

        return $this->engineReaction(1, [
            'expertiseEditData' => $expertiseEditData
        ]);
    }

    /**
     * Process add new expertise.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForEditNewExpertise($inputData, $expertiseUId)
    {
        $expertiseCollection = $this->manageExpertiseRepository->fetch($expertiseUId);

        //if is empty
        if (__isEmpty($expertiseCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Expertise does not exist'));
        }

        //update data
        $updateData = [
            'title'         => $inputData['title'],
            'description'         => $inputData['description'],
            'status'        => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2
        ];

        //Check if expertise updated
        if ($this->manageExpertiseRepository->update($expertiseCollection, $updateData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Expertise updated successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Expertise not updated.'));
    }

    /**
     * Process delete.
     *
     * @param int expertiseUId
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processDelete($expertiseUId)
    {
        $expertiseCollection = $this->manageExpertiseRepository->fetch($expertiseUId);

        //if is empty
        if (__isEmpty($expertiseCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Expertise does not exist.'));
        }

        //Check if expertise deleted
        if ($this->manageExpertiseRepository->delete($expertiseCollection)) {
            return $this->engineReaction(1, [
                'expertiseUId' => $expertiseCollection->_uid
            ], __tr('Expertise deleted successfully.'));
        }

        return $this->engineReaction(18, ['show_message' => true], __tr('Expertise not deleted.'));
    }

}
