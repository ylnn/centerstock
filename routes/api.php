<?php

use Illuminate\Http\Request;

Route::get('/user', function(Request $request){
    return response()->json('HELLO');
});

Route::get('/customer/search/{customerName}', 'Api\ApiController@customerSearch')->name('api.customer.search');

Route::get('/customer/detail/{customer}', 'Api\ApiController@customerDetail')->name('api.customer.detail');