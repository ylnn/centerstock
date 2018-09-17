<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'stock_id', 'customer_id', 'quantity', 'user_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function addQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setOrder(Order $order)
    {
        $this->order_id = $order->id;
    }

    public function addUser(User $user)
    {
        $this->user_id = $user->id;
    }


    public function addCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id ;
    }

    public function addStock(Stock $stock)
    {
        $this->stock_id = $stock->id;
    }
}
