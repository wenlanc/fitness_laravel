<?php
/**
* PricingType.php - Model file
*
* This file is part of the PricingType component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\PricingType\Models;

use App\Yantrana\Base\BaseModel;

class PricingTypeModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'pricingtype';

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
