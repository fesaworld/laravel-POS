<?php

use Illuminate\Support\Facades\Route;

Route::get('/member', 'MemberController@index');
Route::get('/member/{id}', 'MemberController@show');
Route::post('/member', 'MemberController@store');
Route::post('/member/{id}', 'MemberController@update');
Route::delete('/member/{id}', 'MemberController@destroy');
