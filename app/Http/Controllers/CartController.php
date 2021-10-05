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
            } else if (\App\Models\products_detail::where('id', '=', $item['id'])->first() == null){
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $id) {
                    $_SESSION['cart'][$key]['count']++;
                    return ['status'=>'success', 'count'=>$_SESSION['cart'][$key]['count']];
                }
            }
        }
        array_push($_SESSION['cart'], [ 'id'=>$id, 'count'=>1 ]);
        return ['status'=>'success', 'count'=>1];
    }
    public static function SetCount($id, $count){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        foreach ($_SESSION['cart'] as $key => $item) {
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else if (\App\Models\products_detail::where('id', '=', $item['id'])->first() == null){
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $id) {
                    $_SESSION['cart'][$key]['count'] = $count;
                    return ['status'=>'success'];
                }
            }
        }
        array_push($_SESSION['cart'], [ 'id'=>$id, 'count'=>$count ]);
        return ['status'=>'success'];
    }
    public static function RemoveItem($id){
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        foreach ($_SESSION['cart'] as $key => $item){
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else if (\App\Models\products_detail::where('id', '=', $item['id'])->first() == null){
                unset($_SESSION['cart'][$key]);
            } else {
                if ($item['id'] == $id){
                    unset($_SESSION['cart'][$key]);
                    return ['status'=>'success'];
                }
            }
        }
        return ['status'=>'error'];
    }
    // подсчет суммы стоимости товаров в корзине
    public static function GetCost(){
        // корзина хранится в сессии
        // если сессия не начата, ее необходимо начать
        if (!isset($_SESSION)) session_start();
        // если корзины нет или она не соответствует формату, она пересоздается
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $sum = 0; // собственно сумма
        // перебор всех элементов корзины
        foreach ($_SESSION['cart'] as $key => $item){
            // проверка формата хранящихся данных и существования товара в базе
            if (!is_array($item)) {
                unset($_SESSION['cart'][$key]);
            } else if (\App\Models\products_detail::where('id', '=', $item['id'])->first() == null){
                unset($_SESSION['cart'][$key]);
            } else {
                // если товар в порядке,
                // добавляем к сумме стоимость товара
                // помноженную на количество данного товара в корзине
                $prod = \App\Models\products_detail::find($item['id']);
                $sum += $item['count'] * $prod->price;
            }
        }
        // возвращаем пользователю сумму
        return ['status'=>'success', 'sum'=>$sum];
    }
}
