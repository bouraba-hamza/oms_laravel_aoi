<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:32 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Order
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $provider
 * @property string $order_ref
 * @property string $plan
 * @property \Carbon\Carbon $date_arrived
 * @property string $state
 * @property string $observtion
 * @property string $quantity
 * @property string $category
 * @property int $created_by
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $products
 *
 * @package App\Models
 */
class Order extends Eloquent
{
	protected $casts = [
		'created_by' => 'int'
	];

	protected $dates = [
		'date_arrived'
	];

	protected $fillable = [
		'provider',
		'order_ref',
		'plan',
		'date_arrived',
		'state',
		'observtion',
		'quantity',
		'category',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'created_by');
	}

	public function products()
	{
		return $this->hasMany(\App\Models\Product::class);
	}
}
