<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <script src="https://cdn.tiny.cloud/1/wq31xlea48lzktz87apkv0u9ktpoq5podu3azqvcb6lkhpre/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .b-white > div {
            padding: 1em;
        }
        input, select, textarea {
            display: block;
            margin: 0.5em;
            padding: 0.5em;
            width: calc(100% - 2em) !important;
            max-width: calc(100% - 2em) !important;
            box-sizing: content-box;
        }
        textarea {
            height: 150px;
        }
        input[type=submit] {
            padding: 0.5em;
        }
        img {
            max-width: 200px;
            display: block;
        }
    </style>
</head>
<body>
<div class="container">

    @include('includes.header')

    <?php
    $prod = \App\Models\products_detail::find($id);
    ?>

    <div class="b-white">
        <h1 class="page_header">Изменить товар {{ $prod->name }}</h1>

        <div>
            <form name="new-category" action="/products/edit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $id }}" name="id">
                <p>Название товара:</p>
                <input type="text" name="name" value="{{ $prod->name }}">
                <p>Артикул:</p>
                <input type="text" name="vendor" value="{{ $prod->vendor_code }}">
                <p>Цена:</p>
                <input type="number" value="{{ $prod->price }}" name="price">
                <select name="cy">
                    <?php
                    $cys = \App\Models\cys::all();
                    foreach ($cys as $cy){
                        echo '<option value="'.$cy->id.'"';
                        if ($cy->id == $prod->cy_id)
                            echo ' selected';
                        echo '>'.$cy->symbol.'</option>';
                    }
                    ?>
                </select>
                <p>Производитель:</p>
                <select name="brand">
                    <?php
                    $brands = \App\Models\brands::all();
                    foreach ($brands as $brand){
                        echo '<option value="'.$brand->id.'"';
                        if ($brand->id == $prod->brand_id)
                            echo ' selected';
                        echo '>'.$brand->name.'</option>';
                    }
                    ?>
                </select>
                <p>Модель:</p>
                <input type="text" name="model" value="{{ $prod->model }}">
                <p>Краткое описание:</p>
                <textarea name="desc_short">{{ $prod->description_short }}</textarea>
                <p>Полное описание:</p>
                <textarea name="desc" id="desc">{{ $prod->description }}</textarea>
                <p>Адрес изображения товара:</p>
                <select name="image">
                    <option value="/images/default-image.png">default-image.png</option>
                    <?php
                    $dir = $_SERVER['DOCUMENT_ROOT'].'/images/products';
                    $files = scandir($dir);
                    foreach ($files as $item){
                        if ($item != '.' && $item != '..' && !is_dir($dir.'/'.$item)){
                            echo '<option value="/images/products/'.$item.'"';
                            if ($prod->image == '/images/products/'.$item)
                                echo ' selected';
                            echo '>'.$item.'</option>';
                        }
                    }
                    ?>
                </select>
                <img src="{{ $prod->image }}" id="img">
                <p>Длина:</p>
                <input type="number" value="{{ $prod->length }}" name="length">
                <p>Ширина:</p>
                <input type="number" value="{{ $prod->width }}" name="width">
                <p>Высота:</p>
                <input type="number" value="{{ $prod->height }}" name="height">
                <p>Вес:</p>
                <input type="number" value="{{ $prod->weight }}" name="weight">
                <input type="submit" value="Сохранить изменения">
            </form>
            <script>
                $(document).ready(function(){
                    tinymce.init({
                        selector: 'textarea#desc',
                    });

                    $('select[name=image]').on('change', function(e){
                        let src = $(this).val();
                        let img = new Image();
                        img.src = $(this).val();
                        img.onload = function(){
                            $('#img')[0].src = img.src;
                        }
                        img.onerror = function (){
                            $('#img')[0].src = '/images/default-image.png';
                        }
                    });

                    $('form').submit(function(e){
                        if ($('input[name=name]').val().trim() == '' ||
                            $('input[name=vendor]').val().trim() == ''){
                            e.preventDefault();
                        }
                    });
                });
            </script>
        </div>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
