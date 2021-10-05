@extends('layouts.public')

@section('head')
    @parent
    <style>
        .b-white > div {
            padding: 1em;
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
    Изменить категорию - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    @php
    $cat = \App\Models\categories::find($id);
    @endphp

    <div class="b-white p-1">
        <h1 class="page_header">Изменить категорию {{ $cat->name }}</h1>

        <div>
            <form name="new-category" action="/categories/edit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $id }}" name="id">
                <p>Название:</p>
                <input type="text" required name="name" class="form-control" value="{{ $cat->name }}">
                <p>Родительская категория:</p>
                <select name="parent" class="form-control">
                    <option value="none">Нет</option>
                    @foreach (\App\Models\categories::all() as $ccat)
                        <option value="{{ $cat->id }}"
                        @if (isset($_SESSION['current_category']))
                            @if ($_SESSION['current_category'] != null)
                                @if ($ccat->id == $_SESSION['current_category'])
                                selected
                                @endif
                            @endif
                        @else
                            @foreach($cat->parent_categories()->get() as $pcat)
                                @if ($pcat->id == $ccat->id)
                                    selected
                                @endif
                            @endforeach
                        @endif
                        >
                            {{ $ccat->name }}
                        </option>
                    @endforeach
                </select>
                @include('includes.controls.upload-file')
                @include('includes.controls.site-images')
                <input type="hidden" name="image_id">
                <input type="submit" value="Сохранить изменения" class="btn btn-primary">
            </form>
            <script>
                $(document).ready(function(){
                    $('form').submit(function(e){
                        if ($(':invalid').length > 0 ||
                            $('.image-gallery').prop('data-id') == null ||
                            $('.image-gallery').prop('data-id') == undefined){
                            e.preventDefault();
                        } else {
                            $('input[name=image_id]').val($('.image-gallery').prop('data-id'));
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
