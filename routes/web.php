<?php

Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

// Customer
Route::get('/customer', 'Admin\CustomerController@index')->name('admin.customer.index');
Route::get('/customer/create', 'Admin\CustomerController@create')->name('admin.customer.create');
Route::post('/customer/store', 'Admin\CustomerController@store')->name('admin.customer.store');
Route::get('/customer/show/{customer}', 'Admin\CustomerController@show')->name('admin.customer.show');
Route::get('/customer/edit/{customer}', 'Admin\CustomerController@edit')->name('admin.customer.edit');
Route::post('/customer/update/{customer}', 'Admin\CustomerController@update')->name('admin.customer.update');
Route::post('/customer/delete/{customer}', 'Admin\CustomerController@delete')->name('admin.customer.delete');


// Area
Route::get('/area', 'Admin\AreaController@index')->name('admin.area.index');
Route::get('/area/create', 'Admin\AreaController@create')->name('admin.area.create');
Route::post('/area/store', 'Admin\AreaController@store')->name('admin.area.store');
Route::get('/area/show/{area}', 'Admin\AreaController@show')->name('admin.area.show');
Route::get('/area/edit/{area}', 'Admin\AreaController@edit')->name('admin.area.edit');
Route::post('/area/update/{area}', 'Admin\AreaController@update')->name('admin.area.update');
Route::post('/area/delete/{area}', 'Admin\AreaController@delete')->name('admin.area.delete');


// Product
Route::get('/product', 'Admin\ProductController@index')->name('admin.product.index');
Route::get('/product/create', 'Admin\ProductController@create')->name('admin.product.create');
Route::post('/product/store', 'Admin\ProductController@store')->name('admin.product.store');
Route::get('/product/show/{product}', 'Admin\ProductController@show')->name('admin.product.show');
Route::get('/product/edit/{product}', 'Admin\ProductController@edit')->name('admin.product.edit');
Route::post('/product/update/{product}', 'Admin\ProductController@update')->name('admin.product.update');
Route::post('/product/delete/{product}', 'Admin\ProductController@delete')->name('admin.product.delete');


// Stock
Route::get('/stock/{product}', 'Admin\StockController@index')->name('admin.stock.index');
Route::get('/stock/{product}/create', 'Admin\StockController@create')->name('admin.stock.create');
Route::post('/stock/{product}/store', 'Admin\StockController@store')->name('admin.stock.store');
Route::get('/stock/{product}/show/{stock}', 'Admin\StockController@show')->name('admin.stock.show');
Route::get('/stock/{product}/edit/{stock}', 'Admin\StockController@edit')->name('admin.stock.edit');
Route::post('/stock/{product}/update/{stock}', 'Admin\StockController@update')->name('admin.stock.update');
Route::post('/stock/{product}/delete/{stock}', 'Admin\StockController@delete')->name('admin.stock.delete');

// Salesman
Route::get('/salesman/{area?}', 'Admin\SalesmanController@index')->name('admin.salesman.index');
Route::get('/salesman/create', 'Admin\SalesmanController@create')->name('admin.salesman.create');
Route::post('/salesman/store', 'Admin\SalesmanController@store')->name('admin.salesman.store');
Route::get('/salesman/show/{salesman}', 'Admin\SalesmanController@show')->name('admin.salesman.show');
Route::get('/salesman/edit/{salesman}', 'Admin\SalesmanController@edit')->name('admin.salesman.edit');
Route::post('/salesman/update/{salesman}', 'Admin\SalesmanController@update')->name('admin.salesman.update');
Route::post('/salesman/delete/{salesman}', 'Admin\SalesmanController@delete')->name('admin.salesman.delete');