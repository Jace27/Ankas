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
            <form action="/orders/add" method="post" enctype="multipart/form-data">
                @csrf
                <p>Ваше имя:</p>
                <input type="text" name="first_name">
                <p>Ваша фамилия:</p>
                <input type="text" name="last_name">
                <p>Ваше отчество:</p>
                <input type="text" name="third_name">
                <p>Ваша электронная почта:</p>
                <input type="text" name="email">
                <p>Ваш номер телефона:</p>
                <input type="text" name="phone">
                <?php $sum = \App\Http\Controllers\CartController::GetCost(); ?>
                <p>Сумма заказа: <?php echo $sum; ?></p>
                <input type="hidden" value="<?php echo $sum; ?>" name="sum">
                <input type="submit" value="Оформить заказ">
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
