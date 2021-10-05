@extends('layouts.public')

@section('head')
    @parent
@endsection

@section('head-title')
    Войти в личный кабинет - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white section p-1">
        <form action="{{ route('signin') }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <p><b>Ваш E-Mail:</b></p>
            <input type="text" class="d-block form-control" name="email" value="@if(isset($_GET['email'])) {{ $_GET['email'] }} @endif">
            <p><b>Ваш пароль:</b></p>
            <input type="password" class="d-block form-control" name="public_pass">
            <input type="text" class="d-none" name="pass">
            <input type="submit" value="Войти" class="d-block btn btn-primary mt-3">
            <div class="mt-3"><a href="{{ route('signup') }}">Еще не зарегистрированы? Создайте аккаунт</a></div>
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
