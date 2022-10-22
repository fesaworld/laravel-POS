<?php

use Illuminate\Support\Facades\Route;

Route::get('/transaksi', 'TransaksiController@index');
Route::get('/transaksi/{id}', 'TransaksiController@show');
Route::post('/transaksi', 'TransaksiController@store');
Route::post('/transaksi/{id}', 'TransaksiController@update');
Route::delete('/transaksi/{id}', 'TransaksiController@destroy');
