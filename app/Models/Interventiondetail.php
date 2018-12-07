<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Interventiondetail
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $type
 * @property string $observation
 * @property string $status
 * @property int $vehicle_id
 * @property int $intervention_id
 * @property int $created_by
 *
 * @property \App\Models\Vehicle $vehicle
 * @property \App\Models\User $user
 * @property \App\Models\Intervention $intervention
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetailsproducts
 *
 * @package App\Models
 */
class Interventiondetail extends Eloquent
{
    protected $casts = [
        'vehicle_id' => 'int',
        'intervention_id' => 'int',
        'created_by' => 'int'
    ];

    protected $fillable = [
        'type',
        'observation',
        'status',
        'vehicle_id',
        'intervention_id',
        'created_by'
    ];

    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function intervention()
    {
        return $this->belongsTo(\App\Models\Intervention::class);
    }

    public function interventiondetailsproducts()
    {
        return $this->hasMany(\App\Models\Interventiondetailsproduct::class, 'intervention_detail_id');
    }
}
