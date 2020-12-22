<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cart/add', function (Request $request) {
    return \App\Http\Controllers\CartController::AddItem($request->input('prod_id'));
});
Route::post('/cart/remove', function (Request $request) {
    return \App\Http\Controllers\CartController::RemoveItem($request->input('prod_id'));
});
Route::get('/cart/cost', function () {
    return \App\Http\Controllers\CartController::GetCost();
});
