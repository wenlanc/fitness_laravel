<?php

namespace App\Yantrana\Components\UserSetting\Models;

use App\Yantrana\Base\BaseModel;

class UserSubscriptionStripeSponser extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_subscriptions_stripe_promotion';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        '_id'               => 'integer',
        'status'            => 'integer',
        'users__id'         => 'integer'
    ];
}
