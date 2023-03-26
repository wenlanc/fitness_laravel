<?php
/**
* ManagePricingTypeRepository.php - Repository file
*
* This file is part of the PricingType component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\PricingType\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\PricingType\Models\PricingTypeModel;
use File;

class ManagePricingTypeRepository extends BaseRepository 
{
    /**
     * Constructor.
     *
     * @param PricingType $PricingType - PricingType Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch all PricingType list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchListData()
    {
        $dataTableConfig = [
            'searchable' => [
                'title',
                'description'
            ]
        ];

        return PricingTypeModel::dataTables($dataTableConfig)->toArray();
    }

    /**
     * fetch PricingType data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return PricingTypeModel::where('_id', $idOrUid)->first();
        } else {
            return PricingTypeModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * store new PricingType.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function store($input)
    {
        $PricingType = new PricingTypeModel;

        $keyValues = [
            'title',
            'description',
            'status'
        ];

        // Store New PricingType
        if ($PricingType->assignInputsAndSave($input, $keyValues)) {
            activityLog($PricingType->title . ' PricingType created. ');
            return true;
        }
        return false;
    }

    /**
     * Update PricingType Data
     *
     * @param object $PricingType
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function update($PricingType, $updateData)
    {
        // Check if information updated
        if ($PricingType->modelUpdate($updateData)) {
            activityLog($PricingType->title . ' PricingType updated. ');
            return true;
        }

        return false;
    }

    /**
     * Delete PricingType.
     *
     * @param object $PricingType
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function delete($PricingType)
    {
        // Check if PricingType deleted
        if ($PricingType->delete()) {
            activityLog($PricingType->title . ' PricingType deleted. ');
            return  true;
        }

        return false;
    }
}
