<?php

use Illuminate\Http\Request;

Route::get('/user', function(Request $request){
    return response()->json('HELLO');
});

Route::get('/customer/search/{customerName}', 'Api\CustomerApiController@customerSearch')->name('api.customer.search');

Route::get('/customer/detail/{customer}', 'Api\CustomerApiController@customerDetail')->name('api.customer.detail');

Route::get('/product/search/{productName}', 'Api\ProductApiController@productSearch')->name('api.product.search');