<?php

namespace App\Http\Controllers;

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

    public function CreateNew(Request $request) {
        if (\App\Http\Controllers\UserController::UserHaveRight('Добавить товар')) {
            $desc_short = $request->input('desc_short');
            if (strlen($desc_short) > 255) $desc_short = substr($desc_short, 0, 250) . '...';
            $prod = \App\Models\products_detail::create(array(
                'vendor_code' => $request->input('vendor'),
                'brand_id' => $request->input('brand'),
                'cy_id' => $request->input('cy'),
                'price' => $request->input('price'),
                'name' => $request->input('name'),
                'model' => $request->input('model'),
                'image' => $request->input('image'),
                'description' => $request->input('desc'),
                'description_short' => $desc_short,
                'length' => $request->input('length'),
                'width' => $request->input('width'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            if ($request->input('category') != 'none' && $request->input('category') != null) {
                \App\Models\products_categories::insert(array(
                    'category_id' => $request->input('category'),
                    'products_detail_id' => $prod->id,
                ));
            }
            return redirect('/products/' . $prod->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Edit(Request $request) {
        if (\App\Http\Controllers\UserController::UserHaveRight('Изменить товар')) {
            $prod = \App\Models\products_detail::find($request->input('id'));
            $prod->vendor_code = $request->input('vendor');
            $prod->brand_id = $request->input('brand');
            $prod->cy_id = $request->input('cy');
            $prod->price = $request->input('price');
            $prod->name = $request->input('name');
            $prod->model = $request->input('model');
            $prod->image = $request->input('image');
            $prod->description = $request->input('desc');
            $desc_short = $request->input('desc_short');
            if (strlen($desc_short) > 255) $desc_short = substr($desc_short, 0, 250) . '...';
            $prod->description_short = $desc_short;
            $prod->length = $request->input('length');
            $prod->width = $request->input('width');
            $prod->height = $request->input('height');
            $prod->weight = $request->input('weight');
            $prod->save();
            return redirect('/products/' . $prod->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Delete($id) {
        if (\App\Http\Controllers\UserController::UserHaveRight('Удалить товар')) {
            $cat = \App\Models\products_detail::find($id);
            $cat->delete();
            return redirect()->route('main-page');
        } else {
            return redirect()->route('main-page');
        }
    }
}
