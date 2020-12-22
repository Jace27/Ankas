@extends('layouts.app')

@section('head-title')
    Войти в личный кабинет - Ankas
@endsection

@section('head')
    @parent
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white section">
        <form action="{{ route('signin') }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <p><b>Ваш E-Mail:</b></p>
            <input type="text" class="d-block" name="email" value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>">
            <p><b>Ваш пароль:</b></p>
            <input type="password" class="d-block" name="public_pass">
            <input type="text" class="d-none" name="pass">
            <input type="submit" value="Войти" class="d-block">
            <a href="{{ route('signup') }}">Еще не зарегистрированы? Создайте аккаунт</a>
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
