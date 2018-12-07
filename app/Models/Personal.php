<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Personal
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $fonction
 * @property int $utilisateur_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $details_personal

 * @package App\Models
 */
class Personal extends Eloquent
{
    protected $table = 'personals';

    protected $casts = [
        'utilisateur_id' => 'int'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'fonction',
        'utilisateur_id'
    ];

    public function details_personal()
    {
        return $this->hasMany(\App\Models\Personaldetail::class);
    }
}
