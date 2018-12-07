<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 07 Aug 2018 16:53:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Calendar
 *
 * @property int $id
 * @property int $client_id
 * @property int $installateur_id
 * @property string $remarque
 * @property string $lieu
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 * @property string $heure
 * @property string $title
 * @property string $type
 *
 * @package App\Models
 */
class Calendar extends Eloquent
{
    protected $table = 'calendar';
    public $timestamps = false;

    protected $casts = [
    ];

    protected $dates = [
        'update_at'
    ];

    protected $fillable = [
        'client_id',
        'installateur_id',
        'remarque',
        'lieu',
        'update_at',
        'created_at',
        'heure',
        'title',
        'type',
        'id_user',
        'etat',
        'opts_technique',
        'date_vue',
        'end'
    ];
}
