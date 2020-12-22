<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search(Request $request){
        if (trim($request->input('search')) != '')
            return view('search', ['search'=>$request->input('search')]);
        else
            return redirect()->route('main-page');
    }
}
