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
Route::post('/cart/{prod_id}', function ($prod_id, Request $request) {
    return \App\Http\Controllers\CartController::SetCount($prod_id, $request->input('count'));
})->where('prod_id', '[0-9]+');
Route::get('/images/all', [ \App\Http\Controllers\ImageController::class, 'GetAll' ]);
Route::post('/image/upload', [ \App\Http\Controllers\ImageController::class, 'Load' ]);

Route::post('/message/add', [ \App\Http\Controllers\MessageController::class, 'Add' ]);
Route::get('/message/get/chat/{chat_id}', [ \App\Http\Controllers\MessageController::class, 'GetChat' ]);
Route::get('/message/get/chats', [ \App\Http\Controllers\MessageController::class, 'GetChats' ]);
Route::get('/chat/{chat_id}/view', [ \App\Http\Controllers\MessageController::class, 'View' ]);

Route::post('/table/change', [ \App\Http\Controllers\TableController::class, 'Change' ]);
Route::post('/table/delete', [ \App\Http\Controllers\TableController::class, 'Delete' ]);

Route::get('/user/{user_id}/password/reset', [ \App\Http\Controllers\UserController::class, 'ResetPassword' ]);
Route::post('/user/exist', [ \App\Http\Controllers\UserController::class, 'UserExist' ]);

Route::post('/orders/search', [ \App\Http\Controllers\OrdersController::class, 'GetSearched' ]);

Route::get('/product/{id}/get/descriptions', [ \App\Http\Controllers\TableController::class, 'GetDescriptions' ])->where('id', '[0-9]+');

Route::get('/products/generate', function(){
    $categories = \App\Models\categories::where('id', '>', 0)->get('id')->toArray();
    $images = \App\Models\images::where('id', '>', 0)->get('id')->toArray();
    $brands = \App\Models\brands::where('id', '>', 0)->get('id')->toArray();
    $symbols = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ];

    for ($i = 0; $i < 100; $i++){
        $vendor_code = '';
        for ($l = 0; $l < 10; $l++)
            $vendor_code = $vendor_code . get_random_element($symbols);
        $brand = \App\Models\brands::find(get_random_element($brands))->first();
        $name = $brand->name . ' ';
        for ($l = 0; $l < 10; $l++)
            $name = $name . get_random_element($symbols);
        $product = \App\Models\products_detail::create([
            'vendor_code'       => $vendor_code,
            'brand_id'          => $brand->id,
            'cy_id'             => 1,
            'price'             => rand(100, 10000) * 100,
            'name'              => $name,
            'is_available'      => 1,
            'published'         => 1,
            'model'             => explode(' ', $name)[1],
            'description'       => '<p>' . $name . ' - лучшее от бренда ' . $brand->name . '!</p>',
            'description_short' => '<p>' . $name . ' - лучшее от бренда ' . $brand->name . '!</p>',
            'image_id'          => get_random_element($images)['id']
        ]);
        \App\Models\products_categories::create([
            'products_detail_id' => $product->id,
            'category_id' => get_random_element($categories)['id']
        ]);
    }

    dd(\App\Models\products_detail::all());
});
Route::get('/categories/generate', function(){
    $symbols = [ 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ];
    $images = \App\Models\images::where('id', '>', 0)->get('id')->toArray();

    $cats = \App\Models\categories::where('id', '>', 0)->get('id')->toArray();
    for ($i = 0; $i < 10; $i++){
        $pcat = \App\Models\categories::find(get_random_element($cats))->first();
        $ccat = \App\Models\categories::create([
            'name' => $pcat->name . ' ' . get_random_element($symbols) . $pcat->child_categories()->get()->count(),
            'published' => 1,
            'image_id' => get_random_element($images)['id']
        ]);
        \App\Models\subcategories::create([
            'parent_category_id' => $pcat->id,
            'child_category_id' => $ccat->id
        ]);
    }

    dd(\App\Models\categories::all());
});
Route::get('/orders/generate', function(){
    $symbols = [ 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ];
    $numbers = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
    $product_ids = \App\Models\products_detail::where('id', '>', 0)->get('id');

    for ($i = 0; $i < 50; $i++){
        $string = '';
        for ($s = 0; $s < 7; $s++)
            $string = $string.get_random_element($symbols);
        $phone = '';
        for ($s = 0; $s < 11; $s++)
            $phone = $phone.get_random_element($numbers);

        $order = \App\Models\orders::create([
            'last_name' => $string,
            'first_name' => $string,
            'third_name' => $string,
            'phone' => $phone,
            'email' => $string.'@'.$string
        ]);
        \App\Models\orders_products::insert([
            [
                'product_id' => get_random_element($product_ids)->id,
                'order_id' => $order->id
            ]
        ]);
    }

    dd(\App\Models\orders::all());
});

function get_random_element($array){
    return $array[rand(0, count($array) - 1)];
}
