<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Utilisateur
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $adresse
 * @property int $fonction
 * @property int $disabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Utilisateur extends Eloquent
{
    protected $table = 'utilisateurs';

    protected $casts = [
      'disabled' => 'int'
    ];

    protected $hidden = [
        'password'
];
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_number',
        'adresse',
        'fonction',
        'disabled'
    ];


}
