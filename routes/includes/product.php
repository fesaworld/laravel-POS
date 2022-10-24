<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'role:Super Admin',
], function() {
    Route::get('/product', 'ProductController@index');
    Route::get('/product/{id}', 'ProductController@show');
    Route::post('/product', 'ProductController@store');
    Route::post('/product/{id}', 'ProductController@update');
    Route::post('/productStatus/{id}', 'ProductController@updateStatus');
    Route::delete('/product/{id}', 'ProductController@destroy');
});
