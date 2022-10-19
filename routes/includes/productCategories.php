<?php

use Illuminate\Support\Facades\Route;

Route::get('/category', 'ProductCategoryController@index');
Route::get('/category/{id}', 'ProductCategoryController@show');
Route::post('/category', 'ProductCategoryController@store');
Route::post('/category/{id}', 'ProductCategoryController@update');
Route::delete('/category/{id}', 'ProductCategoryController@destroy');
