<?php
/**
* UserGymsModel.php - Model file
*
* This file is part of the Gyms component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Gyms\Models;

use App\Yantrana\Base\BaseModel;

class UserGymsModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'user_gym';

    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'users__id' => 'integer',
        'gym_id' => 'integer'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
