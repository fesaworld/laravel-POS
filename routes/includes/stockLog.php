<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'role:Super Admin',
], function() {
    Route::get('/stockLog', 'StockLogController@index');
    Route::get('/stockLog/{id}', 'StockLogController@show');
    Route::post('/stockLog', 'StockLogController@store');
    Route::post('/stockLog/{id}', 'StockLogController@update');
    Route::delete('/stockLog/{id}', 'StockLogController@destroy');
});
