@extends('layouts.public')

@section('head')
    @parent
    <style>
        .b-white > div {
            padding: 1em;
        }
        input, select {
            display: block;
            width: 200px;
        }
        input[type=submit] {
            padding: 0.5em;
        }
        img {
            max-width: 200px;
            display: block;
        }
        input:invalid {
            background-color: rgba(220,53,69,0.1);
        }
    </style>
@endsection

@section('head-title')
    Оформить заказ - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">Оформление заказа</h1>

        <div>
            <p><a href="/cart/">Вернуться в корзину</a></p>

            <form action="/orders/add" method="post" enctype="multipart/form-data">
                @csrf
                <p>Ваше имя:</p>
                <input type="text" name="first_name" required class="form-control" @if(isset($_SESSION['AuthedUser'])) value="{{ $_SESSION['AuthedUser']['first_name'] }}" @endif>
                <p>Ваша фамилия:</p>
                <input type="text" name="last_name" required class="form-control" @if(isset($_SESSION['AuthedUser'])) value="{{ $_SESSION['AuthedUser']['last_name'] }}" @endif>
                <p>Ваше отчество:</p>
                <input type="text" name="third_name" class="form-control" @if(isset($_SESSION['AuthedUser'])) value="{{ $_SESSION['AuthedUser']['third_name'] }}" @endif>
                <p>Ваша электронная почта:</p>
                <input type="email" name="email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required class="form-control" @if(isset($_SESSION['AuthedUser'])) value="{{ $_SESSION['AuthedUser']['email'] }}" @endif>
                <p>Ваш номер телефона:</p>
                <input type="tel" name="phone" pattern="^((8|\+(\d{1,5}))[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$" minlength="7" maxlength="22" required class="form-control" @if(isset($_SESSION['AuthedUser'])) value="{{ $_SESSION['AuthedUser']['phone'] }}" @endif>
                @php $sum = \App\Http\Controllers\CartController::GetCost(); @endphp
                <p>Сумма заказа: {{ $sum['sum'] }}</p>
                <input type="hidden" value="{{ $sum['sum'] }}" name="sum" class="form-control">
                <input type="submit" value="Оформить заказ" class="btn btn-primary">
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
                        if ($(':invalid').length > 0){
                            e.preventDefault();
                        }
                    });
                });
            </script>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
