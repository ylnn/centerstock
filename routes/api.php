<?php

use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return response()->json('HELLO');
});

Route::middleware(['auth:api'])->group(function () {
    // Customer
    Route::get('/customer/search/{customerName}', 'Api\CustomerSearchController@index')->name('api.customer.search');
    Route::get('/customer/detail/{customer}', 'Api\CustomerDetailController@index')->name('api.customer.detail');

    // Product
    Route::get('/product/search/{productName}', 'Api\ProductApiController@productSearch')->name('api.product.search');
    Route::get('/product/detail/{product}', 'Api\ProductApiController@productDetail')->name('api.product.detail');
});
