<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
	return view('main');
})->name('main-page');

Route::get('/cart', function(){
    return view('cart');
})->name('cart');

Route::get('/signin', function(){
    return view('signin');
})->name('signin');
Route::post('/signin', [Controllers\UserController::class, 'SignIn']);

Route::get('/signup', function(){
    return view('signup');
})->name('signup');
Route::post('/signup', [Controllers\UserController::class, 'SignUp']);

Route::get('/signdown', [Controllers\UserController::class, 'SignDown'])->name('signdown');

Route::get('/categories/{id}', [Controllers\CategoriesController::class, 'GetCategory'])->where('id', '[0-9]+');
Route::get('/products/{id}', [Controllers\ProductsController::class, 'GetProduct'])->where('id', '[0-9]+');

Route::get('/categories/add', function(){
    return view('add-category');
})->name('add-category');
Route::post('/categories/add', [Controllers\CategoriesController::class, 'CreateNew']);

Route::get('/products/add', function(){
    return view('add-product');
})->name('add-product');
Route::post('/products/add', [Controllers\ProductsController::class, 'CreateNew']);

Route::get('/categories/edit/{id}', function($id){
    return view('edit-category', ['id'=>$id]);
});
Route::post('/categories/edit', [Controllers\CategoriesController::class, 'Edit']);

Route::get('/products/edit/{id}', function($id){
    return view('edit-product', ['id'=>$id]);
});
Route::post('/products/edit', [Controllers\ProductsController::class, 'Edit']);

Route::get('/categories/delete/{id}', [Controllers\CategoriesController::class, 'Delete']);
Route::get('/products/delete/{id}', [Controllers\ProductsController::class, 'Delete']);

Route::get('/orders/add', function(){
    return view('add-order');
});
Route::post('/orders/add', [Controllers\OrdersController::class, 'CreateNew']);
