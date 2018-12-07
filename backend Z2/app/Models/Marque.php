<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Marque
 * 
 * @property int $id
 * @property string $marque
 * 
 * @property \Illuminate\Database\Eloquent\Collection $modeles
 *
 * @package App\Models
 */
class Marque extends Eloquent
{
	protected $table = 'marque';
	public $timestamps = false;

	protected $fillable = [
		'marque'
	];

	public function modeles()
	{
		return $this->hasMany(\App\Models\Modele::class, 'marque');
	}
}
