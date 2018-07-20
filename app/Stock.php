<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $dates = ['expiration_date'];
    
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
