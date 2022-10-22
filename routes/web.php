<?php

use Illuminate\Support\Facades\Route;

require_once('includes/auth.php');

Route::group([
    'middleware' => 'auth',
], function() {
    require_once('includes/productCategories.php');
    require_once('includes/user.php');
    require_once('includes/supplier.php');
    require_once('includes/product.php');
    require_once('includes/stockLog.php');
    require_once('includes/member.php');
    require_once('includes/dashboard.php');
});
