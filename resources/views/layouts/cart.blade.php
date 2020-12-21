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

    <div class="b-white product">
        <h1 class="page_header">Корзина</h1>

        <?php
        var_dump($_SESSION['cart']);
        ?>
        <div class="grid g-col6">
            <?php
            foreach ($_SESSION['cart'] as $key => $item){
                
            }
            ?>
        </div>
    </div>

    @include('includes.footer')

</div>
</body>
</html>
