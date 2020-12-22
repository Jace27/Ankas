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

    <div class="b-white">
        <h1 class="page_header">Результаты поиска по "{{ $search }}"</h1>
    </div>

    <div class="b-white">
        <h1 class="page_header">Категории</h1>
        <div class="grid grid-items">
            <?php
            $items = \App\Models\categories::all();
            foreach ($items as $item){
                if (strpos(strtolower($item->name), strtolower($search)) != false ||
                    strpos(strtolower($item->description), strtolower($search)) != false){ ?>
                    <div class="b-white">
                        <a href="/categories/{{ $item->id }}">
                            <span>{{ $item->name }}</span>
                            <img src="{{ $item->image }}">
                        </a>
                    </div> <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="b-white">
        <h1 class="page_header">Товары</h1>
        <div class="grid grid-items">
            <?php
            $items = \App\Models\products_detail::all();
            foreach ($items as $item){
                if (strpos(strtolower($item->name), strtolower($search)) != false ||
                    strpos(strtolower($item->description), strtolower($search)) != false ||
                    strpos(strtolower($item->description_short), strtolower($search)) != false ||
                    strpos(strtolower($item->model), strtolower($search)) != false ||
                    strpos(strtolower($item->vendor_code), strtolower($search)) != false){ ?>
                    <div class="b-white">
                        <a href="/products/{{ $item->id }}">
                            <span>{{ $item->name }}</span>
                            <img src="{{ $item->image }}">
                        </a>
                    </div> <?php
                }
            }
            ?>
        </div>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
