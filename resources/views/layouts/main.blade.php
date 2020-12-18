<?php
session_start();
?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('head-title')</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/css/slider.css">
    <link rel="stylesheet" href="/css/app.css?v=<?php echo rand(); ?>">
    <link rel="icon" href="/images/favicon.png">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/scripts.js"></script>
    @include('includes.head')
</head>
<body>
<div class="container">

    @include('includes.header')

    <div class="banner-wrapper">
        <div id="block-for-slider" class="slider-wrapper">
            <div id="viewport">
                <ul id="slidewrapper">
                    <li class="slide"><img src="images/slider/1.jpg" alt="1" class="slide-img"></li>
                    <li class="slide"><img src="images/slider/2.jpg" alt="2" class="slide-img"></li>
                    <li class="slide"><img src="images/slider/3.jpg" alt="3" class="slide-img"></li>
                    <li class="slide"><img src="images/slider/4.jpg" alt="4" class="slide-img"></li>
                    <li class="slide"><img src="images/slider/5.jpg" alt="5" class="slide-img"></li>
                    <li class="slide"><img src="images/slider/6.jpg" alt="6" class="slide-img"></li>
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
        <script src="/js/slider.js"></script>

        <div class="banner-right">
            <img src="/images/banner-2.jpg">
        </div>
    </div>

    <div class="grid g-col6 grid-items">
        <?php
        if (isset($_SESSION['AuthedUser'])){
            if ($_SESSION['AuthedUser']['role'] == 'Администратор'){ ?>
            <div class="grid-item item-new">
                <img src="/images/new.png">
            </div>
            <script>
                $(document).ready(function () {
                    $('.item-new').click(function(e){
                        $('#new-item-popup').removeClass('d-none');
                        $('#new-item-popup').addClass('d-block');
                    });
                });
            </script>

            <div class="popup-wrapper d-none" id="new-item-popup">
                <div class="popup popup-big">
                    <h2>Добавить новую категорию</h2>
                    <form action="{{ route('add-category') }}" method="post">
                        <p><b>Название:</b></p>
                        <input class="d-block" type="text">
                        <input class="d-block" type="submit" value="Добавить">
                    </form>
                    <button>Отменить</button>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#new-item-popup button').click(function(e){
                        $('#new-item-popup').removeClass('d-block');
                        $('#new-item-popup').addClass('d-none');
                    });
                });
            </script>
            <?php
            }
        }

        $cats = \App\Models\categories::all();
        foreach ($cats as $cat){
            echo '<div>';
            var_dump($cat);
            echo '</div>';
        }
        ?>
    </div>

    <p>На официальном сайте компании АНКАС, вы можете приобрести любое оборудование, представленное в каталоге компании. Для каждого товара у нас выгодные цены с максимально точным и подробным описанием, а также полными характеристиками и собственными фотографиями.</p>

    @include('includes.footer')

</div>
</body>
</html>
