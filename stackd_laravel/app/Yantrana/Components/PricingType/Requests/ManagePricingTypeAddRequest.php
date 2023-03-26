<?php
/**
* ManagePricingTypeAddRequest.php - Request file
*
* This file is part of the PricingType component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\PricingType\Requests;

use App\Yantrana\Base\BaseRequest;

class ManagePricingTypeAddRequest extends BaseRequest
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
            'title'         => 'required|min:3|max:255|unique:pricingtype',
            'description'     => 'required',
            'status'        =>    'sometimes|required'
        ];

        return $rules;
    }
}
