@extends('layouts.public')

@section('head')
    @parent
@endsection

@section('head-title')
    Главная - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    @php
        $_SESSION['current_category'] = null;
    @endphp

    <div class="banner-wrapper">
        <div id="block-for-slider" class="slider-wrapper">
            <div id="viewport">
                <ul id="slidewrapper">
                    <li class="slide"><img src="/images/slider/1.jpg" alt="1" class="slide-img"></li>
                    <li class="slide"><img src="/images/slider/2.jpg" alt="2" class="slide-img"></li>
                    <li class="slide"><img src="/images/slider/3.jpg" alt="3" class="slide-img"></li>
                    <li class="slide"><img src="/images/slider/4.jpg" alt="4" class="slide-img"></li>
                    <li class="slide"><img src="/images/slider/5.jpg" alt="5" class="slide-img"></li>
                    <li class="slide"><img src="/images/slider/6.jpg" alt="6" class="slide-img"></li>
                </ul>

                <div id="prev-next-btns">
                    <div id="prev-btn">
                        <svg class="icon icon-arrowLeft" viewBox="0 0 24 24" width="24px" height="24px">
                            <title>Arrow Left</title>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"></path>
                        </svg>
                    </div>
                    <div id="next-btn">
                        <svg class="icon icon-arrowRight" viewBox="0 0 24 24" width="24px" height="24px">
                            <title>Arrow Right</title>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>

                <ul id="nav-btns">
                    <li class="slide-nav-btn selected"></li>
                    <li class="slide-nav-btn"></li>
                    <li class="slide-nav-btn"></li>
                    <li class="slide-nav-btn"></li>
                    <li class="slide-nav-btn"></li>
                    <li class="slide-nav-btn"></li>
                </ul>
            </div>
        </div>

        <div class="right-banner1 mobile-hidden">
            <img src="/images/banner-2.jpg">
        </div>
        <script src="/js/slider.js"></script>
    </div>

    <div class="b-white">
        @if (isset($_SESSION['AuthedUser']) &&
             ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
            <button class="btn btn-primary m-2" onclick="window.location.assign('{{ route('add-category') }}')">Добавить категорию</button>
        @endif

        <div class="grid grid-items border-top">
            @foreach (\App\Models\categories::all() as $cat)
                @if (count($cat->parent_categories()->get()) == 0)
                    <div class="b-white grid-item p-1" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <a href="/categories/{{ $cat->id }}">
                                <span>{{ $cat->name }}</span>
                                <img src="{{ $cat->image()->file_name }}">
                            </a>
                        </div>
                        @if(isset($_SESSION['AuthedUser']) &&
                            ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                            <div class="border-top pt-2 pl-2 pb-2" style="margin: 0 -0.5em 0 -0.5em; width: calc(100% + 1em);">
                                <button class="btn btn-outline-primary mb-1" onclick="window.location.assign('/categories/delete/{{ $cat->id }}')">Удалить</button>
                                <button class="btn btn-outline-primary mb-1" onclick="window.location.assign('/categories/edit/{{ $cat->id }}')">Изменить</button>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="b-white">
        <div class="border-bottom"><h2 class="page_header">Хиты продаж</h2></div>
        <div class="grid grid-items">
            @php
            $orders = \App\Models\orders::where('created_at', '>', date('Y-m-d', time() - 60*60*24*30))->take(12)->get();
            $items = [];
            foreach ($orders as $order){
                foreach ($order->orders_products()->get() as $prod){
                    $found = false;
                    foreach ($items as $item){
                        if ($item['product']->id == $prod->product()->first()->id){
                            $item['count'] += $prod->count;
                            $found = true;
                        }
                    }
                    if (!$found){
                        array_push($items, ['product'=>$prod->product()->first(), 'count'=>$prod->count]);
                    }
                }
            }
            $items = collect($items)->sortByDesc('count');
            $i = 0;
            @endphp
            @foreach($items as $item)
                <div class="grid-item">
                    <a href="/products/{{ $item['product']->id }}">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div><span>{{ $item['product']->name }}</span></div>
                            <div>
                                @if($item['product']->image() != null)
                                    <img src="{{ $item['product']->image()->file_name }}" />
                                @else
                                    <img src="/images/default-image.png" />
                                @endif
                            </div>
                            <div>
                                <div>
                                    <span class="price">
                                        {{ $item['product']->price() }}
                                        &nbsp;
                                        <button data-id="{{ $item['product']->id }}" class="buy btn btn-primary">
                                            @php $echoed = false; @endphp
                                            @if(isset($_SESSION['cart']))
                                                @foreach($_SESSION['cart'] as $citem)
                                                    @if($citem['id'] == $item['product']->id)
                                                        Уже в корзине<br>(всего {{ $citem['count'] }})
                                                        @php $echoed = true; @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(!$echoed) Купить @endif
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @php $i++; @endphp
                @if($i == 12) @break @endif
            @endforeach
        </div>
    </div>

    <p>На официальном сайте компании АНКАС, вы можете приобрести любое оборудование, представленное в каталоге компании. Для каждого товара у нас выгодные цены с максимально точным и подробным описанием, а также полными характеристиками и собственными фотографиями.</p>
@endsection

@section('footer')
    @parent
    <script>
                $(document).ready(function(){
                    $('a').click(function(e){
                        if (e.target.nodeName == 'BUTTON')
                            e.preventDefault();
                    });

                    $('.buy').click(function(){
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
