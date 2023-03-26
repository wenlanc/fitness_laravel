<?php

/**
* RequestSupportRequest.php - Request file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Requests;

use App\Yantrana\Base\BaseRequest;

class RequestSupportRequest extends BaseRequest
{
    /**
     * Authorization for request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/

    public function authorize()
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return bool
     *-----------------------------------------------------------------------*/

    public function rules()
    {
        return [
            'support_type'  => 'required',
            'description' => 'required',
        ];
    }

    /**
     * Custom Message.
     *
     * @return bool
     *-----------------------------------------------------------------------*/

    public function messages()
    {
        return [
            'support_type.required' => 'The type field is required.',
            'description.required' => 'The description field is required.'
        ];
    }
}
