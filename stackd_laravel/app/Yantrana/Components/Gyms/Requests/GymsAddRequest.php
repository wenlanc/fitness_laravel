<?php
/**
* GymsAddRequest.php - Request file
*
* This file is part of the Gyms component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Requests;

use App\Yantrana\Base\BaseRequest;
use Illuminate\Validation\Rule;

class GymsAddRequest extends BaseRequest
{
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
        return [
            'name'     => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('gym', 'name')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ],
            'gym_image'   => 'required'
        ];
    }
}
