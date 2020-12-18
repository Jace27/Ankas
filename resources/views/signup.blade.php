@extends('layouts.app')

@section('head-title')
    Войти в личный кабинет - Ankas
@endsection

@section('head')
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white section">
        <form action="{{ route('signup') }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <p><b>Ваш E-Mail:</b></p>
            <input type="text" class="d-block" name="email" value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>">
            <p><b>Номер вашего телефона:</b></p>
            <input type="text" class="d-block" name="phone" value="<?php if (isset($_GET['phone'])) echo $_GET['phone']; ?>">
            <p><b>Ваша фамилия:</b></p>
            <input type="text" class="d-block" name="last_name" value="<?php if (isset($_GET['last_name'])) echo $_GET['last_name']; ?>">
            <p><b>Ваше имя:</b></p>
            <input type="text" class="d-block" name="first_name" value="<?php if (isset($_GET['first_name'])) echo $_GET['first_name']; ?>">
            <p><b>Ваше отчество:</b></p>
            <input type="text" class="d-block" name="third_name" value="<?php if (isset($_GET['third_name'])) echo $_GET['third_name']; ?>">
            <p><b>Ваш пароль:</b></p>
            <input type="password" class="d-block" name="public_pass">
            <input type="text" class="d-none" name="pass">
            <input type="submit" value="Зарегистрироваться" class="d-block">
            <a href="{{ route('signin') }}">Уже зарегистрированы? Войдите</a>
        </form>
    </div>
@endsection

@section('footer')
    @parent
    <script src="/js/sha256.js"></script>
    <script>
        $(document).ready(function(){
            $('#form').submit(function(e){
                if (this.elements.pass.value == '') {
                    e.preventDefault();
                    if (this.elements.public_pass.value.trim() != '') {
                        this.elements.pass.value = sha256(this.elements.public_pass.value.trim());
                    }
                    this.elements.public_pass.value = '';
                    this.submit();
                }
            });
        });
    </script>
@endsection
