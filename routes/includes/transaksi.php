<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'role:Admin|Super Admin',
], function() {
    //buat transaksi
    Route::get('/transaksi', 'TransaksiController@index');
    Route::get('/transaksi/{id}', 'TransaksiController@show');
    Route::post('/transaksi', 'TransaksiController@store');
    Route::post('/transaksi/{id}', 'TransaksiController@update');
    Route::delete('/transaksi/{id}', 'TransaksiController@destroy');

// buat member
    Route::get('/transaksiMember/{id}', 'TransaksiController@showMember');

// buat produk
    Route::get('/transaksiProduct/{id}', 'TransaksiController@showProduct');

//buat cart
    Route::get('/cart', 'TransaksiController@indexCart');
    Route::get('/cart/{id}', 'TransaksiController@showCart');
    Route::post('/cart', 'TransaksiController@storeCart');
    Route::post('/cart/{id}', 'TransaksiController@updateCart');
    Route::delete('/cart/{id}', 'TransaksiController@destroyCart');
});
