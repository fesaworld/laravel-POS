<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'role:Admin|Super Admin',
], function() {
    Route::get('/dashboard', 'DashboardController@index');
});
