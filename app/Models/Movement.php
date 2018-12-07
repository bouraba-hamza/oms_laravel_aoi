<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 29 Aug 2018 14:24:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Movement
 *
 * @property int $id
 * @property int $provider
 * @property string $order_ref
 * @property \Carbon\Carbon $date_arrived
 * @property string $plan
 * @property string $observtion
 * @property int $category_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $quantity
 * @property int $BienID
 *
 * @property \App\Models\Category $category
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $facture_providers
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class Movement extends Eloquent
{
    protected $casts = [
        'provider' => 'int',
        'category_id' => 'int',
        'user_id' => 'int',
        'quantity' => 'int',
        'BienID' => 'int'
    ];

    protected $dates = [
        'date_arrived'
    ];

    protected $fillable = [
        'provider',
        'order_ref',
        'date_arrived',
        'plan',
        'observtion',
        'category_id',
        'user_id',
        'quantity',
        'BienID'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(\App\Models\Provider::class, 'provider');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function facture_providers()
    {
        return $this->hasMany(\App\Models\FactureProvider::class, 'MovementID');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
