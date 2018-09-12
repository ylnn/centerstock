<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\SalesmanScope;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password', 'type', 'status', 'area_id', 'phone', 'address', 'desc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function addCustomer($customer)
    {
        return $this->customers()->save($customer);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SalesmanScope);
    }
}
