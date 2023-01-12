<?php


Route::get('/', function () {
  return view('welcome');
});

// home
Route::get('/home', 'PageController@home')->name('home');

// dashboard
Route::get('/dashboard', 'PageController@dashboard')->name('dashboard');