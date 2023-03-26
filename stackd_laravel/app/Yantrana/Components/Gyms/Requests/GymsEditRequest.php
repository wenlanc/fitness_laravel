<?php
/**
* GymsEditRequest.php - Request file
*
* This file is part of the Gyms component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Requests;

use App\Yantrana\Base\BaseRequest;
use Illuminate\Validation\Rule;

class GymsEditRequest extends BaseRequest
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
        $rules = [
            'name'     => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('gym', 'name')->ignore(request()->route('gymsUId'), '_uid')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ],
        ];

        return $rules;
    }
}
