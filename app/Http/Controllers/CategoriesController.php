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

    public function CreateNew(Request $request){
        $cat = \App\Models\categories::create(array(
            'name'=>$request->input('name'),
            'image'=>$request->input('image'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ));
        if ($request->input('parent') != 'none' && $request->input('parent') != null) {
            \App\Models\subcategories::insert(array(
                array(
                    'parent_category_id'=>$request->input('parent'),
                    'child_category_id'=>$cat->id,
                ),
            ));
        }
        return redirect('/categories/'.$cat->id);
    }
    public function Edit(Request $request){
        $cat = \App\Models\categories::find($request->input('id'));
        $cat->name = $request->input('name');
        $cat->image = $request->input('image');
        $cat->save();
        return redirect('/categories/'.$cat->id);
    }
    public function Delete($id){
        $cat = \App\Models\categories::find($id);
        $cat->delete();
        return redirect()->route('main-page');
    }
}
