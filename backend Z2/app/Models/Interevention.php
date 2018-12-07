<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Interevention
 *
 * @property int $id
 * @property \Carbon\Carbon $intervened_at
 * @property string $remarque
 * @property int $id_instalateur
 * @property int $id_costumer
 * @property \Carbon\Carbon $starthour
 * @property \Carbon\Carbon $endhour
 * @property string $validation_resp
 * @property string $upload
 * @property string $status
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Interevention extends Eloquent
{
    protected $table = 'interevention';
    // protected $primaryKey = 'id_intervention';

    protected $casts = [
        'id_instalateur' => 'int',
        'id_costumer' => 'int',
        'user_id' => 'int'
    ];

    protected $dates = [
        'intervened_at',

    ];

    protected $fillable = [
        'intervened_at',
        'remarque',
        'id_instalateur',
        'id_costumer',
        'starthour',
        'endhour',
        'validation_resp',
        'upload',
        'status',
        'user_id'
    ];
}
