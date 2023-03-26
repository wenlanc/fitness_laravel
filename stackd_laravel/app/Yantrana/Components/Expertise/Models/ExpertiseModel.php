<?php
/**
* Expertise.php - Model file
*
* This file is part of the Expertise component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Expertise\Models;

use App\Yantrana\Base\BaseModel;

class ExpertiseModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'expertise';

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
