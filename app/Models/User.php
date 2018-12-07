<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:32 +0000.
 */

namespace App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $costumers
 * @property \Illuminate\Database\Eloquent\Collection $installerproducts
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetails
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetailsproducts
 * @property \Illuminate\Database\Eloquent\Collection $interventions
 * @property \Illuminate\Database\Eloquent\Collection $orders
 * @property \Illuminate\Database\Eloquent\Collection $products
 * @property \Illuminate\Database\Eloquent\Collection $vehicles
 *
 * @package App\Models
 */
class User extends  Authenticatable implements JWTSubject
{
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'is_verified',
        'fonction',
        'disabled'

    ];





    public function costumers()
    {
        return $this->hasMany(\App\Models\Costumer::class, 'created_by');
    }

    public function installerproducts()
    {
        return $this->hasMany(\App\Models\Installerproduct::class, 'created_by');
    }

    public function interventiondetails()
    {
        return $this->hasMany(\App\Models\Interventiondetail::class, 'created_by');
    }

    public function interventiondetailsproducts()
    {
        return $this->hasMany(\App\Models\Interventiondetailsproduct::class, 'created_by');
    }

    public function interventions()
    {
        return $this->hasMany(\App\Models\Intervention::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'created_by');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'created_by');
    }

    public function vehicles()
    {
        return $this->hasMany(\App\Models\Vehicle::class, 'created_by');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }



}
