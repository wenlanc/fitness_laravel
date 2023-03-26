<?php
/**
* ManageExpertiseRepository.php - Repository file
*
* This file is part of the Expertise component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Expertise\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\Expertise\Models\ExpertiseModel;
use File;

class ManageExpertiseRepository extends BaseRepository 
{
    /**
     * Constructor.
     *
     * @param Expertise $Expertise - Expertise Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch all Expertise list.
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

        return ExpertiseModel::dataTables($dataTableConfig)->toArray();
    }

    /**
     * fetch Expertise data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return ExpertiseModel::where('_id', $idOrUid)->first();
        } else {
            return ExpertiseModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * store new Expertise.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function store($input)
    {
        $expertise = new ExpertiseModel;

        $keyValues = [
            'title',
            'description',
            'status'
        ];

        // Store New Expertise
        if ($expertise->assignInputsAndSave($input, $keyValues)) {
            activityLog($expertise->title . ' Expertise created. ');
            return true;
        }
        return false;
    }

    /**
     * Update Expertise Data
     *
     * @param object $Expertise
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function update($expertise, $updateData)
    {
        // Check if information updated
        if ($expertise->modelUpdate($updateData)) {
            activityLog($expertise->title . ' Expertise updated. ');
            return true;
        }

        return false;
    }

    /**
     * Delete Expertise.
     *
     * @param object $Expertise
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function delete($expertise)
    {
        // Check if Expertise deleted
        if ($expertise->delete()) {
            activityLog($expertise->title . ' Expertise deleted. ');
            return  true;
        }

        return false;
    }
}
