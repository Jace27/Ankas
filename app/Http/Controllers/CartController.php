<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public static function AddItem($id){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        foreach ($_SESSION['cart'] as $key => $item) {
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $id) {
                    $_SESSION['cart'][$key]['count']++;
                    return 'success';
                }
            }
        }
        array_push($_SESSION['cart'], [ 'id'=>$id, 'count'=>1 ]);
        return 'success';
    }
    public static function RemoveItem($id){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        foreach ($_SESSION['cart'] as $key => $item){
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $id){
                    unset($_SESSION['cart'][$key]);
                }
            }
        }
        return 'success';
    }
    public static function GetCost(){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $sum = 0;
        foreach ($_SESSION['cart'] as $key => $item){
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else {
                $prod = \App\Models\products_detail::find($item['id']);
                $sum += $item['count'] * $prod->price;
            }
        }
        return $sum;
    }
}
