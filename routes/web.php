<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@home');


Route::get('/carrito', 'ShoppingCartsController@index');
Route::get('/payments/store', 'PaymentsController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('products','ProductsControllers');
Route::resource('in_shopping_carts','InShoppingCartsController',['only' => ['store', 'destroy']]);

Route::resource('compras','ShoppingCartsController',[
	'only' => ['show']
]);

Route::resource('orders','OrdersControllers',[
	'only' => ['index','update']
]);
