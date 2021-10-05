<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableController extends Controller
{
    public function Change(Request $request){
        if (!\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор']))
            return ['status'=>'error', 'message'=>'Недостаточно прав для совершения данного действия'];

        $table = $request->input('table');
        $id    = $request->input('id');
        $field = $request->input('field');
        $value = $request->input('value');

        if ($table == 'users' && $field == 'role_id' && \App\Http\Controllers\UserController::UserHaveRole('Редактор'))
            return ['status'=>'error', 'message'=>'Недостаточно прав для совершения данного действия'];

        $class = '\\App\\Models\\'.$table;
        if (!class_exists($class)) return ['status'=>'error', 'message'=>'Таблицы не существует'];

        if (count($class::where('id', '=', $id)->get()) !== 1) return ['status'=>'error', 'message'=>'Неопределенная запись'];
        $object = $class::where('id', '=', $id)->first();

        if ($field == 'cat_id'){
            $object = $object->hasMany(\App\Models\products_categories::class, 'products_detail_id', 'id')->first();
            if ($object != null) {
                if ($value > 0) {
                    $object->category_id = $value;
                    $object->save();
                } else {
                    $object->delete();
                }
            } else {
                if ($value > 0){
                    \App\Models\products_categories::create([
                        'products_detail_id' => $id,
                        'category_id'        => $value
                    ]);
                }
            }
            return ['status'=>'success'];
        }

        $columns = Schema::getColumnListing($object->getTable());
        if (!in_array($field, $columns)) return ['status'=>'error', 'message'=>'Поля '.$field.' не существует'];

        $object->$field = $value;
        $object->save();
        return ['status'=>'success'];
    }
    public function Delete(Request $request){
        if (!\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор']))
            return ['status'=>'error', 'message'=>'Недостаточно прав для совершения данного действия'];

        $table = $request->input('table');
        $ids   = json_decode($request->input('ids'));

        $class = '\\App\\Models\\'.$table;
        if (!class_exists($class)) return ['status'=>'error', 'message'=>'Таблицы не существует'];

        foreach ($ids as $id){
            $object = $class::where('id', '=', $id)->first();
            $object->delete();
        }
        return ['status'=>'success'];
    }
    public function GetDescriptions($id){
        $product = \App\Models\products_detail::where('id', '=', $id)->first();
        if ($product == null) return ['status'=>'error', 'message'=>'Товар не найден'];
        return ['status'=>'success', 'description'=>$product->description, 'description_short'=>$product->description_short];
    }
}
