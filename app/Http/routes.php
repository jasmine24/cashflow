<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('connect_to_db/{content}/{format}', 'WelcomeController@connectdb');
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//Login
Route::get('login', 'UserController@login');
Route::post('login', 'UserController@handleLogin');
Route::get('logout', 'UserController@logout');
//Register
Route::get('register', 'UserController@register');
Route::post('register', 'UserController@store');
//Inventory
Route::get('inventory', 'InventoryController@index');
Route::post('inventory/add', 'InventoryController@store');
Route::delete('inventory/destroy/{id?}', 'InventoryController@destroy');
Route::get('inventory/edit/{id?}', 'InventoryController@edit');
Route::post('inventory/update/{id?}', 'InventoryController@update');
Route::post('inventory/skuscan', 'InventoryController@skuscan');
//Home
Route::get('home/add/{id?}','HomeController@add');
Route::delete('home/destroy/{id?}', 'HomeController@destroy');
//Checkout
Route::get('checkout', 'CheckoutController@index');
Route::post('checkout/charge/{id?}', 'CheckoutController@charge');
Route::post('checkout/complete/{id?}', 'CheckoutController@complete');


