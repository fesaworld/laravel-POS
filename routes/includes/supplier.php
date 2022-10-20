<?php

use Illuminate\Support\Facades\Route;

Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/{id}', 'SupplierController@show');
Route::post('/supplier', 'SupplierController@store');
Route::post('/supplier/{id}', 'SupplierController@update');
Route::delete('/supplier/{id}', 'SupplierController@destroy');
