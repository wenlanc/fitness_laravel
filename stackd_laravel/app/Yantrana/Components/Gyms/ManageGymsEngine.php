<?php
/**
* ManageGymsEngine.php - Main component file
*
* This file is part of the Pages component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms;

use Auth;
use App\Yantrana\Base\BaseEngine;
use App\Yantrana\Components\Media\MediaEngine;
use App\Yantrana\Components\Gyms\Repositories\ManageGymsRepository;
use App\Yantrana\Components\User\Repositories\UserRepository;

class ManageGymsEngine extends BaseEngine
{
    /**
     * @var ManageGymsRepository - ManageGyms Repository
     */
    protected $manageGymsRepository;

    /**
     * @var UserRepository - User Repository
     */
    protected $userRepository;

    /**
     * @var  MediaEngine $mediaEngine - Media Engine
     */
    protected $mediaEngine;

    /**
     * Constructor.
     *
     * @param ManageGymsRepository $manageGymsRepository - ManageGyms Repository
     * @param  MediaEngine $mediaEngine - Media Engine
     * 
     *-----------------------------------------------------------------------*/
    public function __construct(
        ManageGymsRepository $manageGymsRepository,
        UserRepository $userRepository,
        MediaEngine $mediaEngine
    ) {
        $this->manageGymsRepository = $manageGymsRepository;
        $this->userRepository       = $userRepository;
        $this->mediaEngine          = $mediaEngine;
    }

    /**
     * get Gyms list data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareGymsList()
    {
        $GymsCollection = $this->manageGymsRepository->fetchListData(1);

        $GymsListData = [];
        if (!__isEmpty($GymsCollection)) {
            foreach ($GymsCollection as $key => $GymsData) {
                $GymsImageUrl = '';
                if (isset($GymsData->logo_image) and !__isEmpty($GymsData->logo_image)) {
                    $GymsImageFolderPath = getPathByKey('gym_image', ['{_uid}' => $GymsData->_uid]);
                    $GymsImageUrl = getMediaUrl($GymsImageFolderPath, $GymsData->logo_image);
                }

                $GymsListData[] = [
                    '_id'             => $GymsData['_id'],
                    '_uid'             => $GymsData['_uid'],
                    'name'         => $GymsData['name'],
                    'created_at'     => formatDate($GymsData['created_at']),
                    'updated_at'     => formatDate($GymsData['updated_at']),
                    'status'         => configItem('status_codes', $GymsData['status']),
                    'gymImageUrl'    => $GymsImageUrl
                ];
            }
        }

        return $this->engineReaction(1, [
            'gymListData' => $GymsListData
        ]);
    }

    /**
     * Process add new Gyms.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function processAddNewGyms($inputData)
    {
        //get user id
        $userId = getUserID();

        // Fetch Authority of login user
        $userAuthority = $this->userRepository->fetchUserAuthority($userId);

        //check if empty
        if (__isEmpty($userAuthority)) {
            return $this->engineReaction(1, null, __tr('User not exist.'));
        }

        $userDetails = getUserAuthInfo();

        //store data
        $storeData = [
            'name'                 => $inputData['name'],
            'logo_image'             => $inputData['gym_image'],
            'status'                => (isset($inputData['status'])
                and $inputData['status'] == 'on') ? 1 : 2
        ];

        //Check if Gyms added
        if ($newGyms = $this->manageGymsRepository->storeGyms($storeData)) {
            $GymsImageFolderPath = getPathByKey('gym_image', ['{_uid}' => $newGyms->_uid]);
            $uploadedMedia = $this->mediaEngine->processMoveFile($GymsImageFolderPath, $inputData['gym_image']);

            // check if file uploaded successfully
            if ($uploadedMedia['reaction_code'] == 1) {
                return $this->engineReaction(1, [], __tr('Gyms added successfully.'));
            }

            return $this->engineReaction(2, null, __tr('Something went wrong on server.'));
        }

        return $this->engineReaction(2, null, __tr('Gyms not added.'));
    }

    /**
     * get Gyms edit data.
     *
     *
     * @return object
     *---------------------------------------------------------------- */
    public function prepareGymsUpdateData($GymsUId)
    {
        $GymsCollection = $this->manageGymsRepository->fetch($GymsUId);

        //if is empty then show error message
        if (__isEmpty($GymsCollection)) {
            return $this->engineReaction(1, null, __tr('Gyms does not exist'));
        }

        $GymsImageUrl = '';
        $GymsImageFolderPath = getPathByKey('gym_image', ['{_uid}' => $GymsCollection->_uid]);
        $GymsImageUrl = getMediaUrl($GymsImageFolderPath, $GymsCollection->logo_image);

        $GymsEditData = [];
        if (!__isEmpty($GymsCollection)) {
            $GymEditData = [
                '_id'             => $GymsCollection['_id'],
                '_uid'             => $GymsCollection['_uid'],
                'name'         => $GymsCollection['name'],
                'logo_image'     => $GymsCollection['logo_image'],
                'status'         => $GymsCollection['status'],
                'gyms_image_url' => $GymsImageUrl
            ];
        }

        return $this->engineReaction(1, [
            'gymEditData' => $GymEditData
        ]);
    }

    /**
     * Process edit Gyms.
     *
     * @param array $inputData
     *---------------------------------------------------------------- */
    public function processEditGyms($inputData, $gymsUId)
    {
        $GymsDetails = $this->manageGymsRepository->fetch($gymsUId);

        //if is empty then show error message
        if (__isEmpty($GymsDetails)) {
            return $this->engineReaction(1, null, __tr('Gyms does not exist'));
        }

        $isGymsUpdate = false;

        //update data
        $updateData = [
            'name'                 => $inputData['name'],
            'status'                => (isset($inputData['status']) and $inputData['status'] == 'on') ? 1 : 2
        ];

        // check if update image exists
        if (!\__isEmpty($inputData['gym_image'])) {
            $GymsImageFolderPath = getPathByKey('gym_image', ['{_uid}' => $GymsDetails->_uid]);
            $this->mediaEngine->delete($GymsImageFolderPath, $GymsDetails->logo_image);
            $uploadedMedia = $this->mediaEngine->processMoveFile($GymsImageFolderPath, $inputData['gym_image']);
            // check if file update successfully
            if ($uploadedMedia['reaction_code'] == 1) {
                $isGymsUpdate = true;
                $updateData['logo_image'] = $inputData['gym_image'];
            }
        }

        // Check if Gyms updated
        if ($this->manageGymsRepository->updateGyms($GymsDetails, $updateData)) {
            $isGymsUpdate = true;
        }

        // Check if Gyms updated
        if ($isGymsUpdate) {
            return $this->engineReaction(1, null, __tr('Gyms updated successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Gyms not updated.'));
    }

    /**
     * Process Gyms delete.
     *
     * @param int pageUId
     *
     * @return array
     *---------------------------------------------------------------- */
    public function processDeleteGyms($GymsUId)
    {
        $GymsCollection = $this->manageGymsRepository->fetch($GymsUId);

        //if is empty then show error message
        if (__isEmpty($GymsCollection)) {
            return $this->engineReaction(1, null, __tr('Gyms does not exist'));
        }

        //Check if Gyms deleted
        if ($this->manageGymsRepository->delete($GymsCollection)) {
            return $this->engineReaction(1, [
                'gymsUId' => $GymsCollection->_uid
            ], __tr('Gyms deleted successfully.'));
        }

        return $this->engineReaction(18, null, __tr('Gyms not deleted.'));
    }

}
