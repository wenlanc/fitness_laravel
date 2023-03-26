<?php

namespace App\Yantrana\Components\User\Models;

use App\Yantrana\Base\BaseModel;

class UserGym extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_gym';


    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id'         => 'integer',
        'users__id' => 'integer',
        'gym_id' => 'integer'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [ 'users__id', 'gym_id'];
}
