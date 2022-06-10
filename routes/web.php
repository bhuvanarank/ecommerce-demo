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



Auth::routes();
Auth::routes(['login' => 'auth.login']);

Route::get('/', function () {
return view('auth.login');
});
Route::get('/home', 'MainController@category_list');

Route::get('/category-list', 'MainController@category_list');
Route::get('/add-category-form', 'MainController@add_category_form');
Route::post('/add-category', 'MainController@add_category');
Route::get('/edit-category-form/{id}', 'MainController@edit_category_form');
Route::post('/update-category', 'MainController@add_category');
Route::post('/delete-category', 'MainController@delete_category');

Route::get('/products', 'MainController@products');
Route::get('/add-products-form', 'MainController@add_products_form');
Route::post('/add-products', 'MainController@add_products');
Route::get('/edit-product-form/{id}', 'MainController@edit_product_form');
Route::post('/update-products', 'MainController@add_products');
Route::post('/delete-products', 'MainController@delete_products');

Route::get('/cart-items', 'MainController@cart_items');
Route::get('/add-cartitems-form', 'MainController@add_cartitems_form');
Route::post('/get-products', 'MainController@get_products');
Route::post('/get-price', 'MainController@get_price');
Route::post('/add-cart-items', 'MainController@add_cart_items');
Route::get('/edit-cartitem-form/{id}', 'MainController@edit_cartitem_form');
Route::post('/delete-cartitem', 'MainController@delete_cartitem');

Route::get('/logout', 'Auth\LoginController@logout');