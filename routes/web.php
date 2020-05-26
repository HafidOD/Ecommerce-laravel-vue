<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/carrito', 'ShoppingCartController@show')->name('shopping-cart.show');
Route::get('/carrito/productos', 'ShoppingCartController@products')->name('shopping-cart.products');

Route::get('/pagar','PaymentsController@pay')->name('payments.pay');
Route::get('/pagar/status', 'PaymentsController@payPalStatus');
//Route::get('/pagar/completar','PaymentsController@execute')->name('payments.execute');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/productos/list', 'ProductsController@index')->name('productos');
Route::resource('/in_shopping_carts', 'ProductInShoppingCartsController',[
  "only" => ["store", "destroy"] //indicamos que solo se van a usar las rutas store y destroy
]);
Route::resource('/productos', 'ProductsController');
