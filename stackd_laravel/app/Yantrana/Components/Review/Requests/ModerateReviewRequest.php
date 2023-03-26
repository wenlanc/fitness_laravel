<?php
/**
* ModerateReviewRequest.php - Request file
*
* This file is part of the Review component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Review\Requests;

use App\Yantrana\Base\BaseRequest;

class ModerateReviewRequest extends BaseRequest
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
            'rate_value' => 'required'
        ];
    }
}
