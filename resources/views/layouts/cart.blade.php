<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .grid-items input[type=number] {
            max-width: calc(100% - 2.4em) !important;
            width: calc(100% - 2.4em) !important;
        }
        .price {
            text-align: center;
            display: block;
            width: 100%;
            max-width: 100%;
            font-weight: bold;
            font-size: 20px;
            color: #00975e;
        }
    </style>
</head>
<body>
<div class="container">

    @include('includes.header')

    <div class="b-white product">
        <h1 class="page_header">Корзина</h1>

        <?php
        if(isset($_SESSION['cart'])){
        ?>
        <div class="grid grid-items">
            <?php
            foreach ($_SESSION['cart'] as $key => $item){
                $prod = \App\Models\products_detail::find($item['id']);
                echo '<div class="item-'.$prod->id.'">';
                    echo '<span>'.$prod->name.'</span>';
                    echo '<img src="'.$prod->image.'">';
                    echo '<span class="price">'.$prod->price().'</span>';
                    echo '<input type="number" value="'.$item['count'].'">';
                    echo '<button class="remove">Убрать</button>';
                echo '</div>';
            }
            ?>
        </div>
        <h2>Суммарная стоимость: <span id="sum">0</span></h2>
        <script>
            function getCost(){
                let xhr = new XMLHttpRequest();
                xhr.open('get', '/api/cart/cost');
                xhr.send();
                xhr.onreadystatechange = function(e){
                    if (xhr.readyState == 4){
                        $('#sum').html(xhr.response);
                    }
                }
            }
            $(document).ready(function(){
                getCost();
                $('.remove').click(function(e){
                    let item = $(this).parent();
                    let id = $(this).parent().attr('class').split('item-')[1];
                    let data = new FormData();
                    data.append('prod_id', id);
                    let xhr = new XMLHttpRequest();
                    xhr.open('post', '/api/cart/remove');
                    xhr.send(data);
                    xhr.onreadystatechange = function(e){
                        if (xhr.readyState == 4){
                            console.log(xhr.response);
                            if (xhr.response == 'success'){
                                item.remove();
                                getCost();
                            }
                        }
                    }
                });
            });
        </script>
        <?php
        }
        ?>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
