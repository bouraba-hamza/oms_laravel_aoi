<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 29 Aug 2018 14:24:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Product
 *
 * @property int $id
 * @property string $imei_product
 * @property string $label
 * @property string $model
 * @property \Carbon\Carbon $enabled_date
 * @property string $state
 * @property string $status
 * @property int $movement_id
 * @property int $user_id
 * @property string $observtion
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Movement $movement
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Product extends Eloquent
{
    protected $casts = [
        'movement_id' => 'int',
        'user_id' => 'int'
    ];

    protected $dates = [
        'enabled_date'
    ];

    protected $fillable = [
        'imei_product',
        'label',
        'model',
        'enabled_date',
        'state',
        'status',
        'movement_id',
        'user_id',
        'observtion'
    ];

    public function movement()
    {
        return $this->belongsTo(\App\Models\Movement::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
