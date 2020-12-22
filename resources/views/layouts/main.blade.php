<?php
session_start();
$_SESSION['current_category'] = null;
?>
    <!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
<div class="container">

    @include('includes.header')

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
        <script src="/js/slider.js"></script>

        <div class="banner-right mobile-hidden">
            <img src="/images/banner-2.jpg">
        </div>
    </div>

    <div class="grid grid-items">
        <?php
        if (isset($_SESSION['AuthedUser'])){
            if ($_SESSION['AuthedUser']['role'] == 'Администратор'){ ?>
            <div class="grid-item item-new">
                <a href="{{ route('add-category') }}"><img src="/images/new.png"></a>
            </div>
            <?php
            }
        }

        $cats = \App\Models\categories::all();
        foreach ($cats as $cat){
            $subcats = $cat->parent_categories()->get();
            if (count($subcats) == 0){
            ?>
            <div class="b-white">
                <a href="/categories/{{ $cat->id }}">
                    <span>{{ $cat->name }}</span>
                    <img src="{{ $cat->image }}">
                </a>
                <a href="/categories/edit/{{ $cat->id }}" class="edit"><img src="/images/edit.png"></a>
                <a href="/categories/delete/{{ $cat->id }}" class="delete"><img src="/images/delete.png"></a>
            </div>
            <?php
            }
        }
        ?>
    </div>

    <p>На официальном сайте компании АНКАС, вы можете приобрести любое оборудование, представленное в каталоге компании. Для каждого товара у нас выгодные цены с максимально точным и подробным описанием, а также полными характеристиками и собственными фотографиями.</p>

    @include('includes.footer')

</div>
</body>
</html>
