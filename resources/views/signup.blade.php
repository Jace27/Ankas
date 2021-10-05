@extends('layouts.public')

@section('head-title')
    Войти в личный кабинет - Ankas
@endsection

@section('head')
    @parent
    <style>
        input:invalid {
            background-color: rgba(220,53,69,0.1);
        }
    </style>
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white section p-1">
        <form action="{{ route('signup') }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <p><b>Ваш E-Mail:</b></p>
            <input
                type="email"
                class="d-block form-control"
                name="email"
                pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                required
                value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>">
            <p><b>Номер вашего телефона:</b></p>
            <input
                type="tel"
                class="d-block form-control"
                name="phone"
                pattern="^((8|\+(\d{1,5}))[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$"
                minlength="7"
                maxlength="22"
                required
                placeholder="+7(000)000-00-00"
                value="<?php if (isset($_GET['phone'])) echo $_GET['phone']; ?>">
            <p><b>Ваша фамилия:</b></p>
            <input
                type="text"
                class="d-block form-control"
                name="last_name"
                required
                value="<?php if (isset($_GET['last_name'])) echo $_GET['last_name']; ?>">
            <p><b>Ваше имя:</b></p>
            <input
                type="text"
                class="d-block form-control"
                name="first_name"
                required
                value="<?php if (isset($_GET['first_name'])) echo $_GET['first_name']; ?>">
            <p><b>Ваше отчество:</b></p>
            <input
                type="text"
                class="d-block form-control"
                name="third_name"
                value="<?php if (isset($_GET['third_name'])) echo $_GET['third_name']; ?>">
            <p><b>Ваш пароль:</b></p>
            <input
                type="password"
                class="d-block form-control"
                minlength="8"
                name="public_pass"
                required>
            <p><b>Повторите пароль:</b></p>
            <input
                type="password"
                class="d-block form-control"
                minlength="8"
                name="repeat_pass"
                required>
            <input
                type="text"
                class="d-none"
                name="pass">
            <input
                type="submit"
                value="Зарегистрироваться"
                class="d-block btn btn-primary mt-3">
            <div class="mt-3"><a href="{{ route('signin') }}">Уже зарегистрированы? Войдите в свой аккаунт</a></div>
        </form>
    </div>
@endsection

@section('footer')
    @parent
    <script src="/js/sha256.js"></script>
    <script>
        $(document).ready(function(){
            $('#form').submit(function(e){
                e.preventDefault();
                let form = this;
                if ($(':invalid').length > 0) {
                    display_message('Регистрация', 'Вы заполнили не все поля или заполнили их неправильно');
                    return;
                }
                if(form.elements.public_pass.value != form.elements.repeat_pass.value){
                    display_message('Регистрация', 'Пароли не совпадают');
                    return;
                }
                check_email(form.elements.email.value, function(){
                    form.elements.pass.value = sha256(form.elements.public_pass.value.trim());
                    form.elements.public_pass.value = '';
                    form.elements.repeat_pass.value = '';
                    form.submit();
                });
            });
        });
        function check_email(email, callback){
            let data = new FormData();
            data.append('email', email);
            $.ajax({
                url: '/api/user/exist',
                method: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function(data, status, xhr){
                    console.log(xhr);
                    if (xhr.responseJSON != null && data.status == 'did not exist'){
                        callback();
                    } else if(xhr.responseJSON != null && data.status == 'exist') {
                        display_message('Регистрация', 'Пользователь с данным адресом электронной почты уже существует!');
                    } else {
                        display_message('Проверка существования пользователя', 'Ошибка!<br>'+data.message);
                    }
                },
                error: function(xhr){
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
