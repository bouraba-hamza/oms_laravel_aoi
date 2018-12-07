<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Intervention
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $intervened_at
 * @property string $observation
 * @property string $status
 * @property string $responsible_validation
 * @property int $costumer_id
 * @property int $intervener_id
 * @property int $created_by
 *
 * @property \App\Models\Costumer $costumer
 * @property \App\Models\User $user
 * @property \App\Models\Installer $installer
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetails
 *
 * @package App\Models
 */
class Intervention extends Eloquent
{
    protected $casts = [
        'costumer_id' => 'int',
        'intervener_id' => 'int',
        'created_by' => 'int'
    ];

    protected $dates = [
        'intervened_at'
    ];

    protected $fillable = [
        'intervened_at',
        'observation',
        'status',
        'responsible_validation',
        'costumer_id',
        'intervener_id',
        'created_by'
    ];

    public function costumer()
    {
        return $this->belongsTo(\App\Models\Costumer::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function installer()
    {
        return $this->belongsTo(\App\Models\Installer::class, 'intervener_id');
    }

    public function interventiondetails()
    {
        return $this->hasMany(\App\Models\Interventiondetail::class);
    }
}
