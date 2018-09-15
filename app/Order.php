<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS = [
        "OPEN",
        "WAITING",
        "APPROVED",
        "SHIPPED",
        "DONE"
    ];

    protected $fillable = ['status', 'customer_id', 'user_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function addUser(User $user)
    {
        $user->orders()->save($this);
    }
}
