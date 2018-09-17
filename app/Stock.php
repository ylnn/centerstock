<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['serial', 'quantity', 'purchase_price', 'sale_price', 'user_id'];

    protected $dates = ['expiration_date'];
    
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function isAvailableFor(int $wantedQuantity)
    {
        return $this->quantity >= $wantedQuantity;
    }
}
