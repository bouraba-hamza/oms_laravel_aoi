<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Installer
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $fisrt_name
 * @property string $last_name
 * @property string $phone
 * @property string $mail
 * @property string $cin
 * 
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \Illuminate\Database\Eloquent\Collection $interventions
 *
 * @package App\Models
 */
class Installer extends Eloquent
{
	protected $fillable = [
		'fisrt_name',
		'last_name',
		'phone',
		'mail',
		'cin'
	];

	public function products()
	{
		return $this->belongsToMany(\App\Models\Product::class, 'installerproducts')
					->withPivot('id', 'status', 'created_by')
					->withTimestamps();
	}

	public function interventions()
	{
		return $this->hasMany(\App\Models\Intervention::class, 'intervener_id');
	}
}
