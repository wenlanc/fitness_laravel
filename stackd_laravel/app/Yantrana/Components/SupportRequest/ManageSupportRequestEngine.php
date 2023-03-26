<?php
/**
* ManageSupportRequestEngine.php - Main component file
*
* This file is part of the Support component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\SupportRequest;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\SupportRequest\Repositories\ManageSupportRequestRepository;

class ManageSupportRequestEngine extends BaseEngine
{
    /**
     * @var ManageSupportRequestRepository - ManageSupportRequest Repository
     */
    protected $manageSupportRequestRepository;

    /**
     * Constructor.
     *
     * @param ManageSupportRequestRepository $manageSupportRequestRepository - ManageSupportRequest Repository
     *-----------------------------------------------------------------------*/
    public function __construct(ManageSupportRequestRepository $manageSupportRequestRepository)
    {
        $this->manageSupportRequestRepository = $manageSupportRequestRepository;
    }

    /**
     * get Support list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareSupportList()
    {
        $supportCollection = $this->manageSupportRequestRepository->fetchListData();

        $requireColumns = [
            '_id',
            '_uid',
            'type',
            'created_at' => function ($SupportData) {
                return formatDate($SupportData['created_at']);
            },
            'updated_at' => function ($SupportData) {
                return formatDate($SupportData['updated_at']);
            },
            'status' => function ($SupportData) {
                return configItem('status_codes', $SupportData['status']);
            },
            'description',
            'comment',
            'username'          => function ($SupportData) {
                return $SupportData['username'];
            },
            'userImageUrl'      => function ($SupportData) {
                return $SupportData['userImageUrl'];
            },
            
        ];

        return $this->dataTableResponse($supportCollection, $requireColumns);
    }

    /**
     * Process add new Support.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForAddNewSupport($inputData)
    {
        $storeData = [
            'type'         => $inputData['support_type'],
            'description'         => $inputData['description'],
            'status'        => 1 ,
            'users__id'   => getUserId()
        ];

        //Check if Support added
        if ($this->manageSupportRequestRepository->store($storeData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('SupportRequest added successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('SupportRequest not added.'));
    }

    /**
     * get Support edit data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareUpdateData($supportUId)
    {
        $supportCollection = $this->manageSupportRequestRepository->fetch($supportUId);

        //if is empty
        if (__isEmpty($supportCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Support does not exist'));
        }

        $supportEditData = [];
        if (!__isEmpty($supportCollection)) {
            $supportEditData = [
                '_id'             => $supportCollection['_id'],
                '_uid'             => $supportCollection['_uid'],
                'type'         => $supportCollection['type'],
                'description'     => $supportCollection['description'],
                'created_at'     => formatDate($supportCollection['created_at']),
                'updated_at'     => formatDate($supportCollection['updated_at']),
                'status'         => $supportCollection['status'],
            ];
        }
        
        return $this->engineReaction(1, [
            'supportEditData' => $supportEditData
        ]);
    }

    /**
     * Process add new Support.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForEditNewSupport($inputData, $supportUId)
    {
        $supportCollection = $this->manageSupportRequestRepository->fetch($supportUId);

        //if is empty
        if (__isEmpty($supportCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Support does not exist'));
        }

        //update data
        $updateData = [
            'type'         => $inputData['support_type'],
            'description'         => $inputData['description'],
            'status'        => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2
        ];

        //Check if Support updated
        if ($this->manageSupportRequestRepository->update($supportCollection, $updateData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Support updated successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('Support not updated.'));
    }

    /**
     * Process delete.
     *
     * @param int SupportUId
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processDelete($supportUId)
    {
        $supportCollection = $this->manageSupportRequestRepository->fetch($supportUId);

        //if is empty
        if (__isEmpty($supportCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('Support does not exist.'));
        }

        //Check if Support deleted
        if ($this->manageSupportRequestRepository->delete($supportCollection)) {
            return $this->engineReaction(1, [
                'supportUId' => $supportCollection->_uid
            ], __tr('Support deleted successfully.'));
        }

        return $this->engineReaction(18, ['show_message' => true], __tr('Support not deleted.'));
    }

}
