<?php
/**
* SupportRequestModel.php - Model file
*
* This file is part of the SupportRequest component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\SupportRequest\Models;

use App\Yantrana\Base\BaseModel;

class SupportRequestModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'support_requests';

    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
