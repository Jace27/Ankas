<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .price {
            text-align: center;
            display: block;
            width: 100%;
            font-weight: bold;
            font-size: 20px;
            color: #00975e;
        }
        .price {
            text-align: center;
            display: block;
            width: 100%;
            font-weight: bold;
            font-size: 20px;
            color: #00975e;
        }
        .buy {
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container">

    @include('includes.header')

    <?php
    $cat = \App\Models\categories::find($id);
    $_SESSION['current_category'] = $cat->id;
    ?>

    <div class="b-white">
        <h1 class="page_header">
            {{ $cat->name }}
            <?php
            if (\App\Http\Controllers\UserController::UserHaveRight('Удалить категорию')){ ?>
                <a href="/categories/delete/{{ $cat->id }}" class="delete"><img src="/images/delete.png"></a> <?php
            }
            if (\App\Http\Controllers\UserController::UserHaveRight('Изменить категорию')){ ?>
                <a href="/categories/edit/{{ $cat->id }}" class="edit"><img src="/images/edit.png"></a> <?php
            } ?>
        </h1>
    </div>

    <?php
    $cats = $cat->child_categories()->get();
    $isadmin = false;
    $show = count($cats) != 0;
    if (\App\Http\Controllers\UserController::UserHaveRight('Добавить категорию')){
        $show = true;
    }
    if ($show){
    ?>
    <div class="b-white">
        <h1>Подкатегории ({{ count($cats) }}шт.)</h1>
        <div class="grid grid-items">
            <?php
            if (\App\Http\Controllers\UserController::UserHaveRight('Добавить категорию')){ ?>
                <div class="grid-item item-new">
                    <a href="{{ route('add-category') }}"><img src="/images/new.png"></a>
                </div> <?php
            }

            foreach ($cats as $cat){ ?>
            <div class="b-white">
                <a href="/categories/{{ $cat->id }}">
                    <span>{{ $cat->name }}</span>
                    <img src="{{ $cat->image }}">
                </a>
                <?php
                if (\App\Http\Controllers\UserController::UserHaveRight('Изменить категорию')){ ?>
                    <a href="/categories/edit/{{ $cat->id }}" class="edit"><img src="/images/edit.png"></a> <?php
                }
                if (\App\Http\Controllers\UserController::UserHaveRight('Удалить категорию')){ ?>
                    <a href="/categories/delete/{{ $cat->id }}" class="delete"><img src="/images/delete.png"></a> <?php
                } ?>
            </div> <?php
            }
            ?>
        </div>
    </div>
    <?php } ?>

    <?php
    $products = $cat->products()->get();
    $prods = [];
    foreach ($products as $prod){
        $pcats = $prod->categories()->get();
        foreach ($pcats as $pcat){
            if ($id == $pcat->id){
                array_push($prods, $prod);
            }
        }
    }
    $show = count($prods) != 0;
    if (\App\Http\Controllers\UserController::UserHaveRight('Добавить товар')){
        $show = true;
    }
    if ($show){
    ?>
    <div class="b-white">
        <h1>Товары ({{ count($prods) }}шт.)</h1>
        <div class="grid grid-items">
            <?php
            if (\App\Http\Controllers\UserController::UserHaveRight('Добавить товар')){ ?>
                <div class="grid-item item-new">
                    <a href="{{ route('add-product') }}"><img src="/images/new.png"></a>
                </div> <?php
            }

            foreach ($prods as $prod){ ?>
                <div class="b-white">
                    <a href="/products/{{ $prod->id }}">
                        <span>{{ $prod->name }}</span>
                        <img src="{{ $prod->image }}">
                        <span class="price">{{ $prod->price() }} <button id="{{ $prod->id }}" class="buy">Купить</button></span>
                    </a> <?php
                    if (\App\Http\Controllers\UserController::UserHaveRight('Удалить товар')){ ?>
                        <a href="/products/delete/{{ $prod->id }}" class="delete"><img src="/images/delete.png"></a> <?php
                    }
                    if (\App\Http\Controllers\UserController::UserHaveRight('Изменить товар')){ ?>
                        <a href="/products/edit/{{ $prod->id }}" class="edit"><img src="/images/edit.png"></a> <?php
                    } ?>
                </div> <?php
            }
            ?>
        </div>
        <script>
            $(document).ready(function(){
                $('a').click(function(e){
                    if (e.target.nodeName == 'BUTTON')
                        e.preventDefault();
                });

                $('.buy').click(function(e){
                    let data = new FormData();
                    data.append('prod_id', this.id);
                    let xhr = new XMLHttpRequest();
                    xhr.open('post', '/api/cart/add');
                    xhr.send(data);
                    xhr.onreadystatechange = function(e){
                        if (xhr.readyState == 4){
                            console.log(xhr.response);
                            if (xhr.response == 'success') {
                                $('.buy').html("Добавлено в корзину");
                            }
                        }
                    }
                });
            });
        </script>
    </div>
    <?php } ?>

    @include('includes.footer')

</div>
</body>
</html>
