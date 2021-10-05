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
                'phone' => $request->input('phone')
            ));
            $items = [];
            foreach ($_SESSION['cart'] as $key => $item) {
                array_push($items, array(
                    'product_id' => (int)$item['id'],
                    'count' => $item['count'],
                    'order_id' => $order->id,
                ));
            }
            \App\Models\orders_products::insert($items);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Ваш заказ принят, ожидайте звонка'];
        }
        return redirect()->route('main-page');
    }
    public function ChangeStatus(Request $request, $id){
        if (\App\Http\Controllers\UserController::UserHaveRole(['Администратор', 'Редактор'])) {
            $order = \App\Models\orders::find($id);
            if ($request->input('status_id') != null) {
                $order->status_id = $request->input('status_id');
                $order->save();
            }
        }
        return redirect('/orders/'.$id);
    }
    public function GetSearched(Request $request){
        $response = [];
        if (trim($request->input('search')) != '') {
            $search = \App\Http\Controllers\SearchController::parse_search(trim($request->input('search')));
            $founded = [];
            $objects = \App\Models\orders::all();

            foreach ($objects as $object) {
                $string = $this->format_order($object);
                // ищем каждое отдельное слово из запроса
                foreach ($search as $s) {
                    if (strpos(mb_strtolower($string), mb_strtolower($s)) !== false) {
                        // делаем проверку, чтобы одна запись не попала в ответ больше одного раза
                        $push = true;
                        foreach ($founded as $key => $found) {
                            if ($founded[$key]['object']->id == $object->id) {
                                $founded[$key]['matches'] += 1;
                                $push = false;
                            }
                        }
                        if ($push) {
                            array_push($founded, ['object' => $object, 'matches' => 1]);
                        }
                    }
                }
            }

            // сортируем результаты по кол-ву совпадений
            $founded = \App\Http\Controllers\SearchController::sort_by_matches_number($founded);
            $response = collect($founded)->map(function($item, $key){
                return $item['object'];
            });
        } else {
            $response = \App\Models\orders::all();
        }
        $paginator = $response->paginate(12);

        ?>
        <div class="grid grid-items p-1">
            <?php foreach ($paginator as $order) { ?>
                <div class="b-white border">
                    <a href="/orders/<?php echo $order->id; ?>">
                        <span><b><?php echo $order->last_name; ?> <?php echo $order->first_name; ?> <?php echo $order->third_name; ?></b></span><br>
                        <span><?php echo $order->email; ?></span><br>
                        <span><?php echo $order->phone; ?></span><br>
                        <span><?php echo $order->sum(); ?></span><br>
                        <span><?php echo $order->updated_at; ?></span><br>
                        <span><b><i><?php echo $order->status()->first()->name; ?></i></b></span><br>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
        echo $paginator->withPath('/orders')->appends('search', $request->input('search'))->links('vendor.pagination.bootstrap-4');
    }

    private function format_order($order){
        $string = $order->last_name . ' ' .
                  $order->first_name . ' ' .
                  $order->third_name . ' ' .
                  $order->phone . ' ' .
                  $order->email;
        return \App\Http\Controllers\SearchController::format_string($string);
    }
}
