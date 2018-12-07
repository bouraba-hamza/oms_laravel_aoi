<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesCustomer
 *
 * @property int $id
 * @property string $types
 *
 * @package App\Models
 */
class TypesCustomer extends Eloquent
{
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'id',
        'types'
    ];
}
