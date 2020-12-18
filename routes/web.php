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

Route::get('/signin', function(){
    return view('signin');
})->name('signin');
Route::post('/signin', [Controllers\UserController::class, 'SignIn']);

Route::get('/signup', function(){
    return view('signup');
})->name('signup');
Route::post('/signup', [Controllers\UserController::class, 'SignUp']);

Route::get('/signdown', [Controllers\UserController::class, 'SignDown'])->name('signdown');

Route::post('/categories/add', [Controllers\CategoriesController::class, 'Add'])->name('add-category');
