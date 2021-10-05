<?php

namespace App\Http\Controllers;

use App\Models\products_categories;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function GetProduct($id, Request $request){
        $prod = \App\Models\products_detail::find($id);
        if ($prod == null){
            return abort(404);
        }
        return view('product', ['id'=>$id]);
    }

    // добавление нового товара
    public function CreateNew(Request $request) {
        // добавлять могут только администраторы и редакторы
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            // обрезка короткого описания до 250 символов
            $desc_short = $request->input('desc_short');
            if (strlen($desc_short) > 255) $desc_short = substr($desc_short, 0, 250).'...';
            // валидация происходит на стороне клиента,
            // поэтому сразу заносим данные в базу
            $prod = \App\Models\products_detail::create(array(
                'vendor_code' => $request->input('vendor'),
                'brand_id' => $request->input('brand_id'),
                'cy_id' => 1,
                'price' => $request->input('price'),
                'name' => $request->input('name'),
                'model' => $request->input('model'),
                'image_id' => $request->input('image_id'),
                'description' => $request->input('desc'),
                'description_short' => $desc_short,
                'length' => $request->input('length'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            // создаем запись о принадлежности товара к категории
            if ($request->input('category') != 'none' && $request->input('category') != null) {
                $pcat = \App\Models\products_categories::where([
                    ['category_id', '=', $request->input('category')],
                    ['products_detail_id', '=', $prod->id]
                ])->first();
                if ($pcat == null) {
                    \App\Models\products_categories::insert(array(
                        'category_id' => $request->input('category'),
                        'products_detail_id' => $prod->id,
                    ));
                } else {
                    $pcat->category_id = $request->input('category');
                    $pcat->save();
                }
            }
            // переадресация на страницу новосозданного товара
            return redirect('/products/'.$prod->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Edit(Request $request) {
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $prod = \App\Models\products_detail::find($request->input('id'));
            $prod->vendor_code = $request->input('vendor');
            $prod->brand_id = $request->input('brand_id');
            $prod->cy_id = 1;
            $prod->price = $request->input('price');
            $prod->name = $request->input('name');
            $prod->model = $request->input('model');
            $prod->image_id = $request->input('image_id');
            $prod->description = $request->input('desc');
            $desc_short = $request->input('desc_short');
            if (strlen($desc_short) > 255) $desc_short = substr($desc_short, 0, 250).'...';
            $prod->description_short = $desc_short;
            $prod->length = $request->input('length');
            $prod->width = $request->input('width');
            $prod->height = $request->input('height');
            $prod->weight = $request->input('weight');
            $prod->save();
            return redirect('/products/'.$prod->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Delete($id) {
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $prod = \App\Models\products_detail::find($id);
            $prod->delete();
            return redirect()->route('main-page');
        } else {
            return redirect()->route('main-page');
        }
    }
}
