<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Journalisation
 * 
 * @property int $id
 * @property string $action
 * @property \Carbon\Carbon $created_at
 * @property string $utilisateur
 * @property \Carbon\Carbon $update_at
 *
 * @package App\Models
 */
class Journalisation extends Eloquent
{
	protected $table = 'journalisation';


    protected $dates = [
        'update_at'
    ];


	protected $fillable = [
		'action',
		'created_at',
        'utilisateur',
		'update_at'

	];
}
