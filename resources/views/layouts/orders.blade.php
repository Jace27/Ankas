<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
<div class="container">

    @include('includes.header')

    <?php
    $orders = \App\Models\orders::all();
    ?>

    <div class="b-white">
        <h1 class="page_header">Все заказы</h1>

        <div class="grid grid-items"> <?php
            foreach ($orders as $order){ ?>
            <div class="b-white">
                <a href="/orders/{{ $order->id }}">
                    <span><b>{{ $order->last_name }} {{ $order->first_name }} {{ $order->third_name }}</b></span><br>
                    <span>{{ $order->email }}</span><br>
                    <span>{{ $order->phone }}</span><br>
                    <span>{{ $order->sum }}</span><br>
                    <span>{{ $order->updated_at }}</span><br>
                    <span><b><i>{{ $order->status }}</i></b></span><br>
                </a>
                <?php
                if (\App\Http\Controllers\UserController::UserHaveRight('Изменить статус заказа')){ ?>
                    <?php
                }
                ?>
            </div> <?php
            }
            ?>
        </div>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
