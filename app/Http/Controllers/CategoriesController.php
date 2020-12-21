<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function GetCategory($id, Request $request){
        $cat = \App\Models\categories::find($id);
        if ($cat == null) return abort(404);
        return view('category', ['id'=>$id]);
    }

    public function CreateNew($id, Request $request){
        return redirect()->route('main-page');
    }
    public function Edit(Request $request){
        return redirect()->route('main-page');
    }
    public function Delete(Request $request){
        return redirect()->route('main-page');
    }
}
