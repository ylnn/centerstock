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
