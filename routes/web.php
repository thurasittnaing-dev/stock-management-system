<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Auth Routes
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('test_ui', function () {
    return view('test_ui');
});

// Theme Routes
Route::get('/theme_change', function (Request $request) {
    session()->put('theme', $request->theme);
    return redirect()->back();
})->name('theme_change');

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

    // Location
    Route::resource('location', 'Admin\LocationController');
    Route::get('location_map', 'Admin\LocationController@map')->name('location.map');

    //Brands
    Route::resource('brand', 'Admin\BrandController');

    // Category
    Route::resource('category', 'Admin\CategoryController');

    // Stock Type
    Route::resource('stock_type', 'Admin\StockTypeController');

    // Stock 
    Route::resource('stock', 'Admin\StockController');
    Route::post('stock/export', 'Admin\StockController@export')->name('stock.export');

    // Supplier
    Route::resource('supplier', 'Admin\SupplierController');

    // Roles
    Route::resource('role', 'Admin\RoleController');

    // Users
    Route::resource('user', 'Admin\UserController');

    // Permission
    Route::resource('permission', 'Admin\PermissionController');
    Route::put('permission_update', 'Admin\PermissionController@permission_update')->name('permission_update');
    Route::delete('permission_delete', 'Admin\PermissionController@permission_delete')->name('permission_delete');


    // Purchase History
    Route::resource('purchase_history', 'Admin\PurchaseHistoryController');
});