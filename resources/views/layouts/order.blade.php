<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .b-white > div {
            padding: 1em;
        }
    </style>
</head>
<body>
<div class="container">

    @include('includes.header')

    <?php
    $order = \App\Models\orders::find($id);
    ?>

    <div class="b-white">
        <h1 class="page_header">Заказ №{{ $order->id }}</h1>

        <div>
            <span><b>{{ $order->last_name }} {{ $order->first_name }} {{ $order->third_name }}</b></span><br>
            <span>E-Mail: {{ $order->email }}</span><br>
            <span>Телефон: {{ $order->phone }}</span><br>
            <span>Сумма: {{ $order->sum }}</span><br>
            <span>Дата заказа: {{ $order->created_at }}</span><br>
            <span>Дата обновления состояния: {{ $order->updated_at }}</span><br>
            <span><b>Статус: <i>{{ $order->status }}</i></b></span><br>
            <?php
            if (\App\Http\Controllers\UserController::UserHaveRight('Изменить статус заказа')){ ?>
                <form action="/orders/{{ $order->id }}/change" method="post" enctype="multipart/form-data">
                    @csrf
                    <select name="status">
                        <option disabled selected>Выбрать...</option>
                        <option value="Не оплачен">Не оплачен</option>
                        <option value="Оплачен">Оплачен</option>
                        <option value="В пути">В пути</option>
                        <option value="Доставлен">Доставлен</option>
                    </select>
                    <input type="submit" value="Обновить статус">
                </form>
                <?php
            }
            ?>
        </div>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
