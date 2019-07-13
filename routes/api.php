<?php

Route::middleware(['auth:api'])->group(function () {
    // Customer
    Route::get('/customer/search/{customerName}', 'Api\CustomerSearchController@index')->name('api.customer.search');
    Route::get('/customer/detail/{customer}', 'Api\CustomerDetailController@index')->name('api.customer.detail');

    // Product
    Route::get('/product/search/{productName}', 'Api\ProductController@productSearch')->name('api.product.search');
    Route::get('/product/detail/{product}', 'Api\ProductController@productDetail')->name('api.product.detail');
    
    // Order
    Route::post('/order/query', 'Api\OrderController@index')->name('api.customer.orders');
    Route::get('/order/create/{customer}', 'Api\OrderController@create')->name('api.order.create');
    Route::post('/order/update', 'Api\OrderController@update')->name('api.order.update');


    Route::post('/orderitem/create', 'Api\OrderItemController@create')->name('api.orderitem.create');
    Route::post('/orderitem/destroy', 'Api\OrderItemController@destroy')->name('api.orderitem.destroy');
    Route::post('/orderitem/index', 'Api\OrderItemController@index')->name('api.orderitem.index');

    // Route::post('/customer-orders', 'Api\CustomerOrderController@index')->name('api.customer.orders');

    // Show Orders
});
