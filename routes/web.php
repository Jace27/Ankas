<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
    if (!isset($_SESSION)) session_start();
	return view('main', ['_SESSION'=>$_SESSION]);
})->name('main-page');

Route::get('/cart', function(){
    if (!isset($_SESSION)) session_start();
    return view('cart', ['_SESSION'=>$_SESSION]);
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
Route::get('/orders', function(){
    return view('orders');
})->name('orders');
Route::get('/orders/{id}', function($id){
    if (!isset($_SESSION)) session_start();
    return view('order', ['id'=>$id, '_SESSION'=>$_SESSION]);
})->where('id', '[0-9]+');
Route::post('/orders/{id}/change', [Controllers\OrdersController::class, 'ChangeStatus']);

Route::post('/search', [Controllers\SearchController::class, 'Search'])->name('search');

Route::get('/admin', function (){
    return redirect('/admin/products');
})->name('admin');
Route::get('/admin/products', function (Request $request){
    if (!\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) return redirect('/');
    return view('admin-products', ['sortby'=>$request->input('sortby'), 'mode'=>$request->input('mode')]);
})->name('admin-products');
Route::get('/admin/orders', function (Request $request){
    if (!\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) return redirect('/');
    return view('admin-orders', ['sortby'=>$request->input('sortby'), 'mode'=>$request->input('mode')]);
})->name('admin-orders');
Route::get('/admin/users', function (Request $request){
    if (!\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) return redirect('/');
    return view('admin-users', ['sortby'=>$request->input('sortby'), 'mode'=>$request->input('mode')]);
})->name('admin-users');

Route::get('/chats', function (){
    if (!\App\Http\Controllers\UserController::UserHaveRole('Менеджер')) return redirect('/');
    return view('chats');
})->name('chats');
Route::get('/chat/{chat_id}', function($chat_id){
    if (!\App\Http\Controllers\UserController::UserHaveRole('Менеджер')) return redirect('/');
    return view('manager-chat', ['chat_id' => $chat_id]);
});

Route::get('/account', [\App\Http\Controllers\AccountController::class, 'Account'])->name('account');
Route::post('/account/password/change', [\App\Http\Controllers\AccountController::class, 'PasswordChange']);
Route::post('/account/data/change', [\App\Http\Controllers\AccountController::class, 'DataChange']);
