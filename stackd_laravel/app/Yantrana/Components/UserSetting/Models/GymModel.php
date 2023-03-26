<?php

/**
 * City.php - Model file
 *
 * This file is part of the UserSetting component.
 *-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\UserSetting\Models;

use App\Yantrana\Base\BaseModel;

class GymModel extends BaseModel
{
    /**
     * The custom primary key.
     *
     * @var string
     *----------------------------------------------------------------------- */

    protected $primaryKey = 'id';

    /**
     * @var  string $table - The database table used by the model.
     */
    protected $table = "gym";

    /**
     * @var  array $casts - The attributes that should be casted to native types.
     */
    protected $casts = [];

    /**
     * @var  array $fillable - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
