<?php

namespace App\Yantrana\Components\User\Models;

use App\Yantrana\Base\BaseModel;

class UserExpertise extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_expertise';


    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id'         => 'integer',
        'users__id' => 'integer',
        'expertise_id' => 'integer'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
