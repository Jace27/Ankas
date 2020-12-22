<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
    <style>
        .b-white > div {
            padding: 1em;
        }
        input, select {
            display: block;
            margin: 0.5em;
            padding: 0.5em;
            width: 200px;
            box-sizing: content-box;
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

    <div class="b-white">
        <h1 class="page_header">Оформление заказа</h1>

        <div>
            <form name="new-category" action="/orders/add" method="post" enctype="multipart/form-data">
                @csrf
                <p>Родительская категория:</p>
                <select name="parent">
                    <option value="none">Нет</option>
                    <?php
                    $cats = \App\Models\categories::all();
                    foreach ($cats as $cat){
                        echo '<option value="'.$cat->id.'"';
                        if (isset($_SESSION['current_category'])){
                            if ($_SESSION['current_category'] != null){
                                if ($cat->id == $_SESSION['current_category']){
                                    echo ' selected';
                                }
                            }
                        }
                        echo '>'.$cat->name.'</option>';
                    }
                    ?>
                </select>
                <p>Название категории:</p>
                <input type="text" name="name">
                <p>Адрес изображения категории:</p>
                <select name="image">
                    <option value="/images/default-image.png">default-image.png</option>
                    <?php
                    $dir = $_SERVER['DOCUMENT_ROOT'].'/images/categories';
                    $files = scandir($dir);
                    foreach ($files as $item){
                        if ($item != '.' && $item != '..' && !is_dir($dir.'/'.$item)){
                            echo '<option value="/images/categories/'.$item.'">'.$item.'</option>';
                        }
                    }
                    ?>
                </select>
                <img src="/images/default-image.png" id="img">
                <input type="submit" value="Создать">
            </form>
            <script>
                $(document).ready(function(){
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
                        if ($('input[name=name]').val().trim() == ''){
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
