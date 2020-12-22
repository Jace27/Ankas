<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function CreateNew(Request $request){
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $order = \App\Models\orders::create(array(
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'third_name' => $request->input('third_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'sum' => $request->input('sum'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ));
            $items = [];
            foreach ($_SESSION['cart'] as $key => $item) {
                array_push($items, array(
                    'product_id' => $item['id'],
                    'count' => $item['count'],
                    'order_id' => $order->id,
                ));
            }
            \App\Models\orders_products::insert($items);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Ваш заказ принят, ожидайте звонка'];
        }
        return redirect()->route('main-page');
    }
    public function ChangeStatus($id, Request $request){
        $order = \App\Models\orders::find($id);
        if ($request->input('status') != null)
            $order->status = $request->input('status');
        $order->save();
        return redirect('/orders/'.$id);
    }
}
