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
    $cat = \App\Models\categories::find($id);
    ?>

    <div class="b-white">
        <h1 class="page_header">{{ $cat->name }}</h1>
    </div>

    <?php
    $cats = $cat->child_categories()->get();
    if (count($cats) != 0){
    ?>
    <div class="b-white">
        <h1>Подкатегории ({{ count($cats) }}шт.)</h1>
        <div class="grid g-col6 grid-items">
            <?php
            if (isset($_SESSION['AuthedUser'])){
            if ($_SESSION['AuthedUser']['role'] == 'Администратор'){ ?>
            <div class="grid-item item-new">
                <a href="/categories/{{ $id }}/add"><img src="/images/new.png"></a>
            </div>
            <?php
            }
            }

            foreach ($cats as $cat){ ?>
            <div class="b-white">
                <a href="/categories/{{ $cat->id }}">
                    <span>{{ $cat->name }}</span>
                    <img src="{{ $cat->image }}">
                </a>
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
                break;
            }
        }
    }
    if (count($prods) != 0){
    ?>
    <div class="b-white">
        <h1>Товары ({{ count($products) }}шт.)</h1>
        <div class="grid g-col6 grid-items">
            <?php
            if (isset($_SESSION['AuthedUser'])){
            if ($_SESSION['AuthedUser']['role'] == 'Администратор'){ ?>
            <div class="grid-item item-new">
                <a href="/categories/{{ $id }}/products/add"><img src="/images/new.png"></a>
            </div>
            <?php
            }
            }

            foreach ($prods as $prod){ ?>
                <div class="b-white">
                    <a href="/categories/{{ $id }}/products/{{ $prod->id }}">
                        <span>{{ $prod->name }}</span>
                        <img src="{{ $prod->image }}">
                    </a>
                </div> <?php
            }
            ?>
        </div>
    </div>
    <?php } ?>

    @include('includes.footer')

</div>
</body>
</html>
