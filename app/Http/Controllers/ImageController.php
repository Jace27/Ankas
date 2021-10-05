<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function GetAll(){
        foreach (\App\Models\images::all() as $image)
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$image->file_name))
                $image->delete();
        return \App\Models\images::where('id', '<>', 1)->get();
    }
    public function Load(Request $request){
        if ($request->files->count() > 0){
            $uploaddir     = '/images/'.$request->input('destination').'/';
            $fileSizeLimit = 50 * 1024 * 1024; // 5Mb
            $allowedTypes  = [
                IMAGETYPE_GIF,
                IMAGETYPE_JPEG,
                IMAGETYPE_PNG,
                IMAGETYPE_BMP,
                IMAGETYPE_TIFF_II,
                IMAGETYPE_TIFF_MM
            ];

            $file = $request->file('file');
            if (in_array(exif_imagetype($file->path()), $allowedTypes) && filesize($file->path()) <= $fileSizeLimit){
                $new_file_name = time().'.png';
                move_uploaded_file($file->path(), $_SERVER['DOCUMENT_ROOT'].$uploaddir.$new_file_name);
                \App\Models\images::create(['file_name'=>$uploaddir.$new_file_name]);
                return ['status'=>'success', 'file_name'=>$uploaddir.$new_file_name];
            }
        } else {
            return ['status'=>'error', 'message'=>'Пустой запрос'];
        }
    }
}
