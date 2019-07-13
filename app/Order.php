<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS = [
        "OPEN" => "OPEN",
        "WAITING" => "WAITING",
        "DENIED" => "DENIED",
        "APPROVED" => "APPROVED",
        "SHIPPED" => "SHIPPED",
        "DONE" => "DONE"
    ];

    protected $fillable = ['status', 'customer_id', 'user_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isOpen()
    {
        return $this->status === self::STATUS['OPEN'];
    }

    public function getStatus()
    {
        return $this->status;   
    }

    public function setStatus(string $status)
    {
        if(!$this->isStatusValid($status)) {
            return false;
        }
        self::update(['status' => $status]);
    }

    public function isStatusValid(string $status)
    {
        return in_array($status, self::STATUS);
    }

    public function scopeStatus($query, $status)
    {
        if (is_null($status)) {
            return $query;
        }
        return $query->where('status', $status);
    }

    public function scopeOwner($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeCustomer($query, Customer $customer = null)
    {
        if (is_null($customer)) {
            return $query;
        }
        return $query->where('customer_id', $customer->id);
    }
}
