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