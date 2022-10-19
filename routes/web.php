<?php

use Illuminate\Support\Facades\Route;

require_once('includes/auth.php');

Route::group([
    'middleware' => 'auth',
], function() {
    require_once('includes/productCategories.php');
});
