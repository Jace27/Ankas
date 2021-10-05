<?php

namespace App\Http\Controllers;

use App\Models\subcategories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function GetCategory($id, Request $request){
        if (!isset($_SESSION)) session_start();
        $cat = \App\Models\categories::find($id);
        if ($cat == null) return abort(404);
        return view('category', ['cat'=>$cat, '_SESSION'=>$_SESSION]);
    }

    public function CreateNew(Request $request){
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $cat = \App\Models\categories::create(array(
                'name' => $request->input('name'),
                'image_id' => $request->input('image_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            if ($request->input('parent') != 'none' && $request->input('parent') != null) {
                $scat = \App\Models\subcategories::where([['parent_category_id', '=', $request->input('parent')],['child_category_id', '=', $cat->id]])->first();
                if ($scat == null) {
                    \App\Models\subcategories::insert(array(
                        array(
                            'parent_category_id' => $request->input('parent'),
                            'child_category_id' => $cat->id,
                        ),
                    ));
                } else {
                    $scat->parent_category_id = $request->input('parent');
                    $scat->save();
                }
            }
            return redirect('/categories/'.$cat->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Edit(Request $request) {
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $cat = \App\Models\categories::find($request->input('id'));
            $cat->name = $request->input('name');
            $cat->image_id = $request->input('image_id');
            $cat->save();
            return redirect('/categories/'.$cat->id);
        } else {
            return redirect()->route('main-page');
        }
    }
    public function Delete($id) {
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $cat = \App\Models\categories::find($id);
            $cat->delete();
            return redirect()->route('main-page');
        } else {
            return redirect()->route('main-page');
        }
    }
}
