<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Modele
 * 
 * @property int $id
 * @property string $modele
 * @property int $marque
 * 
 *
 * @package App\Models
 */
class Modele extends Eloquent
{
	protected $table = 'modele';
	public $timestamps = false;

	protected $casts = [
		'marque' => 'int'
	];

	protected $fillable = [
		'modele',
		'marque'
	];

	public function marque()
	{
		return $this->belongsTo(\App\Models\Marque::class, 'marque');
	}
}
