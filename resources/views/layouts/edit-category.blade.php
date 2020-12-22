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

    <?php
    $cat = \App\Models\categories::find($id);
    ?>

    <div class="b-white">
        <h1 class="page_header">Изменить категорию {{ $cat->name }}</h1>

        <div>
            <form name="new-category" action="/categories/edit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $id }}" name="id">
                <p>Название категории:</p>
                <input type="text" name="name" value="{{ $cat->name }}">
                <p>Адрес изображения категории:</p>
                <select name="image">
                    <option value="/images/default-image.png">default-image.png</option>
                    <?php
                    $dir = $_SERVER['DOCUMENT_ROOT'].'/images/categories';
                    $files = scandir($dir);
                    foreach ($files as $item){
                        if ($item != '.' && $item != '..' && !is_dir($dir.'/'.$item)){
                            echo '<option value="/images/categories/'.$item.'"';
                            if ('/images/categories/'.$item == $cat->image)
                                echo ' selected';
                            echo '>'.$item.'</option>';
                        }
                    }
                    ?>
                </select>
                <img src="{{ $cat->image }}" id="img">
                <input type="submit" value="Сохранить изменения">
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
