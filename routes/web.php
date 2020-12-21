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
Route::get('/categories/{cat}/products/{prod}', [Controllers\ProductsController::class, 'GetProduct'])->where('cat', '[0-9]+')->where('prod', '[0-9]+');

Route::get('/categories/{id?}/add', [Controllers\CategoriesController::class, 'CreateNew'])->where('id', '[0-9]+');
