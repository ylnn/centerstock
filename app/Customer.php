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
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Customer');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function addOrder($order, $user)
    {
        $order->user_id = $user->id;
        return $this->orders()->save($order);
    }
}
