<?php
/**
* UserSettingPrivacyEditRequest.php - Request file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\UserSetting\Requests;

use App\Yantrana\Base\BaseRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UserSettingPrivacyEditRequest extends BaseRequest
{
    /**
     * Secure form.
     *------------------------------------------------------------------------ */
    protected $securedForm = false;

    /**
     * Unsecured/Un encrypted form fields.
     *------------------------------------------------------------------------ */
    protected $unsecuredFields = [];

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
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        return [
            // 'first_name'        => 'required|min:3|max:45',
            // 'last_name'         => 'required|min:3|max:45',
            //'username'          => 'required|min:5|max:45|unique:users,username',
            // 'mobile_number'     => 'required|max:15|unique:users,mobile_number',
            //'email_address'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6|max:30',
            // 'gender'              => [
            //     'required',
            //     Rule::in(array_keys(configItem('user_settings.gender'))),
            // ],
            'confirm_password'   => 'required|min:6|max:30|same:password',
            // 'birthday'                => 'sometimes|validate_age',
            // 'accepted_terms'     => 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function messages()
    {
        $ageRestriction = configItem('age_restriction');

        return [
            
            //'accepted_terms.required' => __tr("Please accept all terms and conditions.")
        ];
    }
}
