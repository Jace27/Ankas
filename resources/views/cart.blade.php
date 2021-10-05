@extends('layouts.public')

@section('head')
    @parent
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
@endsection

@section('head-title')
    Корзина - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white product p-1">
        <h1 class="page_header">Корзина</h1>

        @if(isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0)
            <div class="grid grid-items" style="margin: 0 -0.5em;">
                @foreach ($_SESSION['cart'] as $key => $item)
                    @php
                    $prod = \App\Models\products_detail::find($item['id']);
                    @endphp
                    @if ($prod == null)
                        @php unset($_SESSION['cart'][$key]); @endphp
                        @continue
                    @endif
                    <div class="item-{{ $prod->id }} hovering border">
                        <span>{{ $prod->name }}</span>
                        <img src="{{ $prod->image()->file_name }}">
                        <span class="price">{{ $prod->price() }}</span>
                        <input type="number" value="{{ $item['count'] }}" class="form-control" onchange="changed_number(this)">
                        <button class="remove btn btn-outline-primary mt-2" data-id="{{ $prod->id }}">Убрать</button>
                    </div>
                @endforeach
            </div>
            <h2>Суммарная стоимость: <span id="sum">0</span></h2>
            <div class="center"><button onclick="window.location.assign('/orders/add')" class="btn btn-primary">Оформить заказ</button></div>
            <br>
            <script>
                function getCost(){
                    $.ajax({
                        url: '/api/cart/cost',
                        method: 'get',
                        data: null,
                        processData: false,
                        contentType: false,
                        success: function(data, status, xhr){
                            console.log(xhr);
                            if (xhr.responseJSON != null && data.status == 'success'){
                                $('#sum').html(data.sum);
                            } else {
                                display_message('Суммарная стоимость товаров', 'Ошибка!<br>'+data.message);
                            }
                        },
                        error: function(data){
                            console.log(xhr);
                        }
                    });
                }
                $(document).ready(function(){
                    getCost();
                    $('.remove').click(function(e){
                        let item = $(this).parent();
                        let id = this.dataset.id;
                        let data = new FormData();
                        data.append('prod_id', id);
                        $.ajax({
                            url: '/api/cart/remove',
                            method: 'post',
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function(data, status, xhr){
                                console.log(xhr);
                                if (xhr.responseJSON != null && data.status == 'success'){
                                    item.remove();
                                    getCost();
                                } else {
                                    display_message('Удаление товара из корзины', 'Ошибка!<br>'+data.message);
                                }
                            },
                            error: function(data){
                                console.log(xhr);
                            }
                        });
                    });
                });
                function changed_number(object){
                    let product = $(object).parent();
                    let classes = product[0].className.split(' ');
                    let p_class = '';
                    for (let i = 0; i < classes.length; i++)
                        if (classes[i].indexOf('item-') == 0)
                            p_class = classes[i];
                    let id = parse_item(p_class);
                    $.ajax({
                        url: '/api/cart/'+id+'?count='+$(object).val(),
                        method: 'post',
                        data: null,
                        processData: false,
                        contentType: false,
                        success: function(data, status, xhr){
                            console.log(xhr);
                            if (xhr.responseJSON != null && data.status == 'success'){
                                getCost();
                            } else {
                                display_message('Изменение количество товаров', 'Ошибка!<br>'+data.message);
                            }
                        },
                        error: function(data){
                            console.log(xhr);
                        }
                    });
                }
                function parse_item(item) {
                    let id = item.split('item-');
                    if (id.length > 1){
                        id = id[1];
                        return id;
                    }
                    return -1;
                }
            </script>
        @else
            <br>
            <h4 class="ml-2">Пусто</h4>
        @endif
    </div>
@endsection

@section('footer')
    @parent
@endsection
