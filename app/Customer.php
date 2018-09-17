<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'email', 'phone', 'area_id'];
    protected $dates = ['deleted_at'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function setOrder($order)
    {
        return $this->orders()->save($order);
    }

    public function setUser(User $user)
    {
        $this->user_id = $user->id;
    }
}
