<?php
/**
* ManageSupportRequestRepository.php - Repository file
*
* This file is part of the SupportRequest component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\SupportRequest\Repositories;

use App\Yantrana\Base\BaseRepository;
use App\Yantrana\Components\SupportRequest\Models\SupportRequestModel;
use File;

class ManageSupportRequestRepository extends BaseRepository 
{
    /**
     * Constructor.
     *
     * @param SupportRequest $SupportRequest - SupportRequest Model
     *-----------------------------------------------------------------------*/
    public function __construct()
    {
    }

    /**
     * fetch all SupportRequest list.
     *
     * @return array
     *---------------------------------------------------------------- */
    public function fetchListData()
    {
        $dataTableConfig = [
            'searchable' => [
                'type',
                'description'
            ]
        ];
        $supportDTCollection =  SupportRequestModel::leftJoin('users', 'support_requests.users__id', '=', 'users._id')
        ->leftJoin('user_authorities', 'users._id', '=', 'user_authorities.users__id')
        ->leftJoin('user_profiles', 'support_requests.users__id', '=', 'user_profiles.users__id')
        ->select(
            __nestedKeyValues([
                'support_requests.*',
                'user_profiles' => [
                    'profile_picture'
                ],
                'users'   => [
                    '_uid as user_uid', 
                    'username'
                ]
            ])
        )
        ->dataTables($dataTableConfig)
        ->toArray();

        $tableData = [];
        foreach ($supportDTCollection["data"] as $key => $support) {
            if (!__isEmpty($support["profile_picture"])) {
                $profileImageFolderPath = getPathByKey('profile_photo', ['{_uid}' => $support["user_uid"]]);
                $userImageUrl = getMediaUrl($profileImageFolderPath, $support["profile_picture"]);
            } else {
                $userImageUrl = noThumbImageURL();
            }

            $tableData[] = [
                '_id'               => $support["_id"],
                '_uid'              => $support["_uid"],
                'status'            => $support["status"],
                'created_at'        => formatDiffForHumans($support["created_at"]),
                'updated_at'        => formatDiffForHumans($support["updated_at"]),
                'username'          => $support["username"],
                'userImageUrl'      => $userImageUrl,
                'profilePicture'    => $support["profile_picture"],
                'isPremiumUser'     => isPremiumUser($support["users__id"]),
                'type'              => $support["type"],
                'description'       => $support["description"],
                'comment'           => $support["comment"]
            ];
        }    
        $supportDTCollection["data"] = $tableData;
        return $supportDTCollection;
    }

    /**
     * fetch SupportRequest data.
     *
     * @param int $idOrUid
     *
     * @return eloquent collection object
     *---------------------------------------------------------------- */
    public function fetch($idOrUid)
    {
        //check is numeric
        if (is_numeric($idOrUid)) {
            return SupportRequestModel::where('_id', $idOrUid)->first();
        } else {
            return SupportRequestModel::where('_uid', $idOrUid)->first();
        }
    }

    /**
     * store new SupportRequest.
     *
     * @param array $input
     *
     * @return array
     *---------------------------------------------------------------- */
    public function store($input)
    {
        $supportRequest = new SupportRequestModel;

        $keyValues = [
            'type',
            'description',
            'status',
            'users__id'
        ];

        // Store New SupportRequest
        if ($supportRequest->assignInputsAndSave($input, $keyValues)) {
            activityLog($supportRequest->type . ' SupportRequest created. ');
            return true;
        }
        return false;
    }

    /**
     * Update SupportRequest Data
     *
     * @param object $SupportRequest
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function update($supportRequest, $updateData)
    {
        // Check if information updated
        if ($supportRequest->modelUpdate($updateData)) {
            activityLog($supportRequest->type . ' supportRequest updated. ');
            return true;
        }

        return false;
    }

    /**
     * Delete SupportRequest.
     *
     * @param object $SupportRequest
     *
     * @return bool
     *---------------------------------------------------------------- */
    public function delete($supportRequest)
    {
        // Check if SupportRequest deleted
        if ($supportRequest->delete()) {
            activityLog($supportRequest->type . ' SupportRequest deleted. ');
            return  true;
        }

        return false;
    }
}
