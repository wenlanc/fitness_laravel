<?php
/**
* ManagePricingTypeEngine.php - Main component file
*
* This file is part of the PricingType component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\PricingType;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\PricingType\Repositories\ManagePricingTypeRepository;

class ManagePricingTypeEngine extends BaseEngine
{
    /**
     * @var ManagePricingTypeRepository - ManagePricingType Repository
     */
    protected $managePricingTypeRepository;

    /**
     * Constructor.
     *
     * @param ManagePricingTypeRepository $managePricingTypeRepository - ManagePricingType Repository
     *-----------------------------------------------------------------------*/
    public function __construct(ManagePricingTypeRepository $managePricingTypeRepository)
    {
        $this->managePricingTypeRepository = $managePricingTypeRepository;
    }

    /**
     * get PricingType list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function preparePricingTypeList()
    {
        $PricingTypeCollection = $this->managePricingTypeRepository->fetchListData();

        $requireColumns = [
            '_id',
            '_uid',
            'title',
            'created_at' => function ($PricingTypeData) {
                return formatDate($PricingTypeData['created_at']);
            },
            'updated_at' => function ($PricingTypeData) {
                return formatDate($PricingTypeData['updated_at']);
            },
            'status' => function ($PricingTypeData) {
                return configItem('status_codes', $PricingTypeData['status']);
            },
        ];

        return $this->dataTableResponse($PricingTypeCollection, $requireColumns);
    }

    /**
     * Process add new PricingType.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForAddNewPricingType($inputData)
    {
        $storeData = [
            'title'         => $inputData['title'],
            'description'         => $inputData['description'],
            'status'        => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2,
        ];

        //Check if PricingType added
        if ($this->managePricingTypeRepository->store($storeData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('PricingType added successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('PricingType not added.'));
    }

    /**
     * get PricingType edit data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareUpdateData($pricingtypeUId)
    {
        $PricingTypeCollection = $this->managePricingTypeRepository->fetch($pricingtypeUId);

        //if is empty
        if (__isEmpty($PricingTypeCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('PricingType does not exist'));
        }

        $pricingtypeEditData = [];
        if (!__isEmpty($PricingTypeCollection)) {
            $pricingtypeEditData = [
                '_id'             => $PricingTypeCollection['_id'],
                '_uid'             => $PricingTypeCollection['_uid'],
                'title'         => $PricingTypeCollection['title'],
                'description'     => $PricingTypeCollection['description'],
                'created_at'     => formatDate($PricingTypeCollection['created_at']),
                'updated_at'     => formatDate($PricingTypeCollection['updated_at']),
                'status'         => $PricingTypeCollection['status'],
            ];
        }

        return $this->engineReaction(1, [
            'pricingtypeEditData' => $pricingtypeEditData
        ]);
    }

    /**
     * Process add new PricingType.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function prepareForEditNewPricingType($inputData, $pricingtypeUId)
    {
        $PricingTypeCollection = $this->managePricingTypeRepository->fetch($pricingtypeUId);

        //if is empty
        if (__isEmpty($PricingTypeCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('PricingType does not exist'));
        }

        //update data
        $updateData = [
            'title'         => $inputData['title'],
            'description'         => $inputData['description'],
            'status'        => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2
        ];

        //Check if PricingType updated
        if ($this->managePricingTypeRepository->update($PricingTypeCollection, $updateData)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('PricingType updated successfully'));
        }

        return $this->engineReaction(2, ['show_message' => true], __tr('PricingType not updated.'));
    }

    /**
     * Process delete.
     *
     * @param int pricingtypeUId
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processDelete($pricingtypeUId)
    {
        $PricingTypeCollection = $this->managePricingTypeRepository->fetch($pricingtypeUId);

        //if is empty
        if (__isEmpty($PricingTypeCollection)) {
            return $this->engineReaction(1, ['show_message' => true], __tr('PricingType does not exist.'));
        }

        //Check if PricingType deleted
        if ($this->managePricingTypeRepository->delete($PricingTypeCollection)) {
            return $this->engineReaction(1, [
                'pricingtypeUId' => $PricingTypeCollection->_uid
            ], __tr('PricingType deleted successfully.'));
        }

        return $this->engineReaction(18, ['show_message' => true], __tr('PricingType not deleted.'));
    }

}
