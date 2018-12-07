<?php




namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TypesUtilisateur
 *
 * @property int $id
 * @property string $types
 *
 * @package App\Models
 */
class TypesUtilisateur extends Eloquent
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
