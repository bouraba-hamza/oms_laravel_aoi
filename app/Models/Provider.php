<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Provider
 *
 * @property int $id
 * @property string $name
 * @property string $contact_gsm
 * @property int $types_providers_id
 * @property string $tel_fix
 * @property string $mail
 * @property string $city
 * @property string $departement
 * @property string $code_postal
 * @property string $region
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Provider extends Eloquent

{


    protected $casts = [
        'disabled' => 'int'
    ];

    protected $fillable = [
        'name',
        'contact_gsm',
        'types_providers_id',
        'tel_fix',
        'mail',
        'city',
        'departement',
        'code_postal',
        'region',
        'address',
        'categorie_id'
    ];
}
