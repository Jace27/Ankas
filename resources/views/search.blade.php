@extends('layouts.public')

@section('head')
    @parent
@endsection

@section('head-title')
    Поиск - {{ $search }} - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">Результаты поиска по "{{ $search }}"</h1>
    </div>
    <div class="b-white">
        <h1 class="page_header">Категории</h1>
        <div class="grid grid-items border-top">
            @foreach ($results as $result)
                @if ($result instanceof \App\Models\categories)
                    <div class="b-white grid-item">
                        <a href="/categories/{{ $result->id }}">
                            <span>{{ $result->name }}</span>
                            <img src="{{ $result->image()->file_name }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="b-white">
        <h1 class="page_header">Товары</h1>
        <div class="grid grid-items border-top">
            @foreach ($results as $result)
                @if ($result instanceof \App\Models\products_detail)
                    <div class="b-white grid-item">
                        <a href="/products/{{ $result->id }}">
                            <span>{{ $result->name }}</span>
                            <img src="{{ $result->image()->file_name }}">
                            <span class="price">{{ $result->price() }} <button id="{{ $result->id }}" class="buy btn btn-primary">Купить</button></span>
                        </a>
                        @if (isset($_SESSION['AuthedUser']) &&
                             ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                            <div class="border-top pt-2 pl-2" style="margin: 0 -0.5em">
                                <button class="btn btn-primary" onclick="window.location.assign('/products/delete/{{ $result->id }}')">Удалить</button>
                                <button class="btn btn-primary" onclick="window.location.assign('/products/edit/{{ $result->id }}')">Изменить</button>
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
