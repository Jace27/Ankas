<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function GetProduct($catId, $prodId, Request $request){
        $cat = \App\Models\categories::find($catId);
        $prod = \App\Models\products_detail::find($prodId);
        if ($cat == null || $prod == null){
            return abort(404);
        }
        return view('product', ['catId'=>$catId, 'prodId'=>$prodId]);
    }

    public function CreateNew(Request $request){
        return redirect()->route('main-page');
    }
    public function Edit(Request $request){
        return redirect()->route('main-page');
    }
    public function Delete(Request $request){
        return redirect()->route('main-page');
    }
}
