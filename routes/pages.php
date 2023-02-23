<?php


Route::get('/', function () {
  return redirect()->route('login');
});

// home
Route::get('/home', 'PageController@home')->name('home');

// dashboard
Route::get('admin/dashboard', 'PageController@dashboard')->name('dashboard');