<?php

use Illuminate\Support\Facades\Route;


// Auth Routes
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// Language Routes
Route::get('lang/change', 'LangController@change')->name('changeLang');

// Pages Routes
include 'pages.php';




/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    // location
    Route::resource('location', 'Admin\LocationController');
});