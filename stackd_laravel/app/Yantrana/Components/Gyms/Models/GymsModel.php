<?php
/**
* GymsModel.php - Model file
*
* This file is part of the Gyms component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Models;

use App\Yantrana\Base\BaseModel;

class GymsModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'gym';

    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        '_id' => 'integer',
        'status' => 'integer',
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
