@extends('layouts.public')

@section('head')
    @parent
@endsection

@section('head-title')
    @php
        $_SESSION['current_category'] = $cat->id;
    @endphp

    Категория {{ $cat->name }} - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">
            {{ $cat->name }}
            <div>
                @if (isset($_SESSION['AuthedUser']) && ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                    <button onclick="window.location.assign('/categories/edit/{{ $cat->id }}')" class="btn btn-outline-primary" style="margin-top: -0.4em">Изменить</button>
                @endif
                @if (isset($_SESSION['AuthedUser']) && ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                    <button onclick="window.location.assign('/categories/delete/{{ $cat->id }}')" class="btn btn-outline-primary" style="margin-top: -0.4em">Удалить</button>
                @endif
            </div>
        </h1>
    </div>
    @php
        $cats = $cat->child_categories()->paginate(18, ['*'], 'cat_page');
        $isadmin = false;
        $show = count($cats) != 0;
        if (isset($_SESSION['AuthedUser']) && ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор')){
            $show = true;
        }
    @endphp
    @if ($show)
        <div class="b-white">
            <div class="d-flex flex-row justify-content-between">
                <h1 class="p-1">Подкатегории ({{ count($cat->child_categories()->get()) }}шт.)</h1>
                @if (isset($_SESSION['AuthedUser']) && ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                    <button class="btn btn-outline-primary mr-2 mt-3 mb-3" onclick="window.location.assign('{{ route('add-category') }}')">
                        Добавить
                    </button>
                @endif
            </div>
            <div class="grid grid-items">

                @foreach ($cats as $tcat)
                    <div class="b-white p-1 grid-item">
                        <a href="/categories/{{ $tcat->id }}">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div><span>{{ $tcat->name }}</span></div>
                                <div><img src="{{ $tcat->image()->file_name }}"></div>
                                @if (isset($_SESSION['AuthedUser']) && ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                                    <div class="border-top pt-2 pl-2" style="margin: 0 -0.5em">
                                        <button class="btn btn-outline-secondary" onclick="window.location.assign('/categories/delete/{{ $tcat->id }}')">Удалить</button>
                                        <button class="btn btn-outline-secondary" onclick="window.location.assign('/categories/edit/{{ $tcat->id }}')">Изменить</button>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="m-2">
                {{ $cat->child_categories()->paginate(18, ['*'], 'cat_page')->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-2 b-white filters">
            <p><b>Цена:</b></p>
            <p>от <input type="number" min="0" value="<?php if (isset($_GET['cost_from'])) echo $_GET['cost_from']; else echo '0.00'; ?>" step="0.01" name="cost_from" class="form-inline form-control"></p>
            <p>до <input type="number" min="0" value="<?php if (isset($_GET['cost_to'])) echo $_GET['cost_to']; else echo '1000000.00'; ?>" step="0.01" name="cost_to" class="form-inline form-control"></p>
            <hr>
            <p><b>Производитель:</b></p>
            @foreach(\App\Models\brands::all() as $brand)
                <div class="form-check">
                    <input type="checkbox" name="brand" value="{{ $brand->id }}" class="form-check-input" id="checkbox_brand_{{ $brand->name }}" <?php if (isset($_GET['brands'])){ if (in_array($brand->id, explode(',', $_GET['brands']))){ echo 'checked'; } } ?>>
                    <label class="form-check-label" for="checkbox_brand_{{ $brand->name }}">{{ $brand->name }}</label>
                </div>
            @endforeach
            <hr>
            <div class="center">
                <button class="btn btn-primary btn-product-filter">Применить</button>
            </div>
            <script>
                $(document).ready(function(){
                    $('.btn-product-filter').click(function(){
                        let href = window.location.pathname;
                        href += '?cost_from='+$('.filters [name=cost_from]').val();
                        href += '&cost_to='+$('.filters [name=cost_to]').val();
                        @if(isset($_GET['prod_page']))
                            href += '&prod_page={{ $_GET['prod_page'] }}';
                        @endif
                        let brands = [];
                        $('.filters [type=checkbox]:checked').each(function(index, elem){
                            brands.push($(elem).val());
                        });
                        href += '&brands='+brands.join(',');
                        window.location.assign(href);
                    });
                });
            </script>
        </div>
        <div class="col-10 pr-0 pb-0">
            @php
                $products = $cat->products()->get();
                $prods = [];
                foreach ($products as $prod){
                    $pcats = $prod->categories()->get();
                    foreach ($pcats as $pcat){
                        if ($cat->id == $pcat->id){
                        	if (isset($_GET['cost_from']))
                        	    if ($prod->price < $_GET['cost_from'])
                        	        continue;
                        	if (isset($_GET['cost_to']))
                        	    if ($prod->price > $_GET['cost_to'])
                        	        continue;
                        	if (isset($_GET['brands']))
                        	    if (!in_array($prod->brand_id, explode(',', $_GET['brands'])))
                        	        continue;

                            array_push($prods, $prod);
                        }
                    }
                }
                $count = count($prods);
                $prods = collect($prods)->paginate(18, null, null, 'prod_page');
                $show = count($prods) != 0;
                if (isset($_SESSION['AuthedUser']) &&
                    ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор')){
                    $show = true;
                }
            @endphp
            @if ($show)
                <div class="b-white">
                    <div class="d-flex flex-row justify-content-between">
                        <h1 class="p-1">Товары ({{ $count }}шт.)</h1>
                        @if (isset($_SESSION['AuthedUser']) &&
                             ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                            <button class="btn btn-outline-primary mr-2 mt-3 mb-3" onclick="window.location.assign('{{ route('add-product') }}')">
                                Добавить
                            </button>
                        @endif
                    </div>
                    <div class="grid grid-items">
                        @foreach ($prods as $prod)
                            <div class="b-white p-1 grid-item">
                                <a href="/products/{{ $prod->id }}">
                                    <div class="d-flex flex-column justify-content-between h-100">
                                        <div><span>{{ $prod->name }}</span></div>
                                        <div>
                                        @if($prod->image() != null)
                                            <img src="{{ $prod->image()->file_name }}" />
                                        @else
                                            <img src="/images/default-image.png" />
                                        @endif
                                        </div>
                                        <div>
                                            <div>
                                                <span class="price">
                                                    {{ $prod->price() }}
                                                    &nbsp;
                                                    <button data-id="{{ $prod->id }}" class="buy btn btn-primary">
                                                        @php $echoed = false; @endphp
                                                        @if(isset($_SESSION['cart']))
                                                            @foreach($_SESSION['cart'] as $item)
                                                                @if($item['id'] == $prod->id)
                                                                    Уже в корзине<br>(всего {{ $item['count'] }})
                                                                    @php $echoed = true; @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if(!$echoed)
                                                            Купить
                                                        @endif
                                                    </button>
                                                </span>
                                            </div>
                                            @if(isset($_SESSION['AuthedUser']) &&
                                                ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                                                <div class="border-top pt-2 pl-2" style="margin: 0 -0.5em">
                                                    <button class="btn btn-outline-secondary" onclick="window.location.assign('/products/delete/{{ $prod->id }}')">Удалить</button>
                                                    <button class="btn btn-outline-secondary" onclick="window.location.assign('/products/edit/{{ $prod->id }}')">Изменить</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="m-2">
                        {{ $prods->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                    </div>
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
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
