<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .product {
            min-height: 500px;
            padding: 1em;
        }
        .prod_img {
            padding: 1em;
            float: left;
            max-width: 60%;
        }
        #price_buy {
            padding: 4em 0;
        }
        .price {
            color: #00975e;
            font-size: 30px;
            font-weight: bold;
            margin: 0 2em 0 0;
        }
        .b-good-cards__location-availability:before {
            content: "\e010 ";
            margin-top: -4px;
            color: #00975e;
            font-family: 'megaicons';
        }
        .b-good-cards__location-delivery:before {
            content: "\e07f ";
            margin-top: -4px;
            color: #00975e;
            font-family: 'megaicons';
        }
        .b-good-cards__location-item:before {
            content: "\e100 ";
            margin-top: -4px;
            color: #00975e;
            font-family: 'megaicons';
        }
    </style>
</head>
<body>
<div class="container">

    @include('includes.header')

    <?php
    $prod = \App\Models\products_detail::find($id);
    ?>

    <div class="b-white product">
        <h1 class="page_header">
            {{ $prod->name }}
            <a href="/products/edit/{{ $prod->id }}" class="edit"><img src="/images/edit.png"></a>
            <a href="/products/delete/{{ $prod->id }}" class="delete"><img src="/images/delete.png"></a>
        </h1>
        <div class="prod_img">
            <img src="{{ $prod->image }}">
        </div>
        <div id="price_buy">
            <span class="price">{{ $prod->price() }}</span>
            <button class="buy">Купить</button>
        </div>
        <div>
            <div>
                <span class="b-good-cards__location-availability">&nbsp;В наличии: Москва</span>
            </div>
            <div>
                <span class="b-good-cards__location-delivery">&nbsp;Очень быстрая доставка в г. Челябинск</span>
            </div>
            <div>
                <span class="b-good-cards__location-item">&nbsp;Самовывоз в г. Челябинск, ул. Газизуллина, 2Б</span>
            </div>
        </div>
        <h1>Описание</h1>
        {!! $prod->description !!}
    </div>

    <script>
        $(document).ready(function(){
            $('.buy').click(function(e){
                let data = new FormData();
                data.append('prod_id', {{ $id }});
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

    @include('includes.footer')

</div>
</body>
</html>
