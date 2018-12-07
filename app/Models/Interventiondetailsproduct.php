<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Interventiondetailsproduct
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $intervention_detail_id
 * @property int $installer_product_id
 * @property int $created_by
 * @property \App\Models\Installerproduct $installerproduct
 * @property \App\Models\User $user
 * @property \App\Models\Interventiondetail $interventiondetail
 *
 * @package App\Models
 */
class Interventiondetailsproduct extends Eloquent
{
    protected $casts = [
        'intervention_detail_id' => 'int',
        'installer_product_id' => 'int',
        'created_by' => 'int'
    ];

    protected $fillable = [
        'intervention_detail_id',
        'installer_product_id',
        'created_by'
    ];

    public function installerproduct()
    {
        return $this->belongsTo(\App\Models\Installerproduct::class, 'installer_product_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function interventiondetail()
    {
        return $this->belongsTo(\App\Models\Interventiondetail::class, 'intervention_detail_id');
    }
}
