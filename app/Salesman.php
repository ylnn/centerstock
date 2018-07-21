<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    protected $table = 'salesmen';

    protected $fillable = ['status', 'name', 'area_id','email','phone','address','desc','password'];

    public function area()
    {
        return $this->belongsTo('App\Area');
    }
}
