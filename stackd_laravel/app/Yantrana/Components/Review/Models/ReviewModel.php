<?php
/**
* ReviewModel.php - Model file
*
* This file is part of the Review component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Review\Models;

use App\Yantrana\Base\BaseModel;
use App\Yantrana\Components\User\Models\User;

class ReviewModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'user_reviews';

    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Get users related to the role
     *
     * @return void
     *---------------------------------------------------------------- */
    public function reviewedForUser()
    {
        return $this->hasMany(User::class, '_id', 'to_users__id');
    }
}
