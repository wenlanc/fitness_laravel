<?php
/**
* ManageGymsRepository.php - Repository file
*
* This file is part of the Gyms component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\Gyms\Models\{
    GymsModel,
    UserGymsModel
};

class ManageGymsRepository extends BaseRepository
{
    /**
     * Constructor.
     *
     * @param Page $gyms - Gyms Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch all Gyms list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchListData()
    {
        return GymsModel::get();
    }

    /**
     * fetch Gyms data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return GymsModel::where('_id', $idOrUid)->first();
        } else {
            return GymsModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * store new Gyms.
     *
     * @param array $input
     *
     * @return array|object|bool
     *---------------------------------------------------------------- */
    public function storeGyms($input)
    {
        $gyms = new GymsModel;

        $keyValues = [
            'name',
            'logo_image',
            'status',
        ];

        // Store New Gyms
        if ($gyms->assignInputsAndSave($input, $keyValues)) {
            activityLog($gyms->name . ' Gyms created. ');
            return $gyms;
        }
        return false;
    }

    /**
     * Update Gyms Data
     *
     * @param object $gyms
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function updateGyms($gyms, $updateData)
    {
        // Check if information updated
        if ($gyms->modelUpdate($updateData)) {
            activityLog($gyms->title . ' Gyms updated. ');
            return true;
        }
        return false;
    }

    /**
     * Delete Gyms.
     *
     * @param object $gyms
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function delete($gyms)
    {
        // Check if page deleted
        if ($gyms->delete()) {
            activityLog($gyms->title . ' Gyms deleted. ');
            return  true;
        }

        return false;
    }

    /**
     * Fetch by user and Gyms id
     *
     * @param number $userId
     * @param number $gymsId 
     * 
     * @return bool
     *---------------------------------------------------------------- */
    public function fetchByUserAndGymsId($userId, $gymsId)
    {
        return UserGymsModel::where([
            'users__id' => $userId,
            'gym_id' => $gymsId
        ])->first();
    }

    public function storeUserGyms($userGymsStoreData)
    {
        $keyValues = [
            'status' => 1,
            'users__id',
            'gym_id'
        ];

        $userGymsModel = new UserGymsModel;

        // Check if user Gyms added
        if ($userGymsModel->assignInputsAndSave($userGymsStoreData, $keyValues)) {
            return true;
        }
        return false;   // on failed
    }
}
