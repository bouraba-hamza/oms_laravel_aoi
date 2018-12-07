<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 29 Aug 2018 14:24:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Plan
 * 
 * @property int $id
 * @property string $plan_name
 * @property int $categorie_id
 *
 * @package App\Models
 */
class Plan extends Eloquent
{
	protected $table = 'plan';
	public $timestamps = false;

	protected $casts = [
		'categorie_id' => 'int'
	];

	protected $fillable = [
		'plan_name',
		'categorie_id'
	];
}
