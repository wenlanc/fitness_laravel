<?php

namespace App\Yantrana\Components\User\Models;

use App\Yantrana\Base\BaseModel;

class UserTime extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_time';


    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id'         => 'integer',
        'users__id' => 'integer'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = ['day', 'users__id', 'start', 'end'];
}
