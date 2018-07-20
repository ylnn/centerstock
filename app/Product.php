<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'base_price'];

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
}
