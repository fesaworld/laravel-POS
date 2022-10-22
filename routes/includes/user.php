<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'role:Super Admin',
], function() {
Route::get('/user', 'UserController@index');
Route::get('/user/{id}', 'UserController@show');
Route::post('/user', 'UserController@store');
Route::post('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@delete');
});
