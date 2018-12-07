<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Installerproduct
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $status
 * @property int $product_id
 * @property int $installer_id
 * @property int $created_by
 * 
 * @property \App\Models\Product $product
 * @property \App\Models\User $user
 * @property \App\Models\Installer $installer
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetailsproducts
 *
 * @package App\Models
 */
class Installerproduct extends Eloquent
{
	protected $casts = [
		'product_id' => 'int',
		'installer_id' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'status',
		'product_id',
		'installer_id',
		'created_by'
	];

	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'created_by');
	}

	public function installer()
	{
		return $this->belongsTo(\App\Models\Installer::class);
	}

	public function interventiondetailsproducts()
	{
		return $this->hasMany(\App\Models\Interventiondetailsproduct::class, 'installer_product_id');
	}
}
