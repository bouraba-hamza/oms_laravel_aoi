<?php


namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Personaldetail
 *
 * @property int $id
 * @property string $imei_product
 * @property string $date_product
 * @property string $label
 * @property string $date_label
 * @property int $personal_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Personal $personal
 *
 * @package App\Models
 */
class Personaldetail extends Eloquent
{
    protected $casts = [
        'id' => 'int',
        'personal_id' => 'int'
    ];

    protected $fillable = [
        'imei_product',
        'date_product',
        'label',
        'date_label',
        'personal_id'

    ];

    public function personal()
    {
        return $this->belongsTo(\App\Models\Personal::class);
    }


}
