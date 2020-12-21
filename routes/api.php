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

Route::post('/cart', function (Request $request) {
    session_start();
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    } else {
        foreach ($_SESSION['cart'] as $key => $item){
            if (!is_array($item)){
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $request->input('prod_id')) {
                    $_SESSION['cart'][$key]['count']++;
                    return 'success';
                }
            }
        }
    }
    array_push($_SESSION['cart'], [ 'id'=>$request->input('prod_id'), 'count'=>1 ]);
    return 'success';
});
