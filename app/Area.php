<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'desc'];
    
    protected $dates = ['deleted_at'];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function salesmans()
    {
        return $this->hasMany('App\Salesman');
    }
}
