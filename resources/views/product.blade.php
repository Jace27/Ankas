@extends('layouts.public')

@php
$prod = \App\Models\products_detail::find($id);
@endphp

@section('head')
    @parent
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
@endsection

@section('head-title')
    {{ $prod->name }} - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white product p-1">
        <h1 class="page_header">
            {{ $prod->name }}
            @if(isset($_SESSION['AuthedUser']) &&
                ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                <a href="/products/delete/{{ $prod->id }}" class="btn-delete"><img src="/images/delete.png"></a>
                <a href="/products/edit/{{ $prod->id }}" class="btn-edit"><img src="/images/edit.png"></a>
            @endif
        </h1>
        <div class="prod_img">
            <img src="{{ $prod->image()->file_name }}">
        </div>
        <div id="price_buy">
            <span class="price">{{ $prod->price() }}</span>
            <div class="center"><button class="buy btn btn-primary" data-id="{{ $prod->id }}>Купить</button></div>
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
                let button = this;
                let data = new FormData();
                data.append('prod_id', button.dataset.id);
                $.ajax({
                    url: '/api/cart/add',
                    method: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data, status, xhr){
                        console.log(xhr);
                        if (xhr.responseJSON != null && data.status == 'success'){
                            $(button).html('Добавлено в корзину<br>(всего '+data.count+')');
                        } else {
                            display_message('Добавление товара в корзину', 'Ошибка!<br>'+data.message);
                        }
                    },
                    error: function(xhr){
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection

@section('footer')
    @parent
@endsection
