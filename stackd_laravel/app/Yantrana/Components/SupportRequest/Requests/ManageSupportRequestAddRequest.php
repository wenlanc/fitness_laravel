<?php
/**
* ManageSupportRequestAddRequest.php - Request file
*
* This file is part of the SupportRequest component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\SupportRequest\Requests;

use App\Yantrana\Base\BaseRequest;

class ManageSupportRequestAddRequest extends BaseRequest
{
    /**
     * Loosely sanitize fields.
     *------------------------------------------------------------------------ */
    protected $looseSanitizationFields = ['description' => true];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the add author client post request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        $rules = [
            'support_type'         => 'required',
            'description'     => 'required',
            'status'        =>    'sometimes|required'
        ];

        return $rules;
    }
}
