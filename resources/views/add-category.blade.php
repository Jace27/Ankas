@extends('layouts.public')

@section('head')
    @parent
    <style>
        @media (min-width: 1300px)                      { img { max-width: 25%; } }
        @media (max-width: 1299px)                      { img { max-width: 35%; } }
        @media (min-width: 800px) and (max-width: 999px){ img { max-width: 50%; } }
        @media (min-width: 600px) and (max-width: 799px){ img { max-width: 65%; } }
        @media (min-width: 400px) and (max-width: 599px){ img { max-width: 80%; } }
        @media (min-width: 200px) and (max-width: 399px){ img { max-width: 100%; } }
        input:invalid {
            background-color: rgba(220,53,69,0.1);
        }
    </style>
@endsection

@section('head-title')
    Создать категорию - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">Создать новую категорию</h1>

        <div>
            <form name="new-category" action="{{ route('add-category') }}" method="post" enctype="multipart/form-data">
                @csrf
                <p>Родительская категория:</p>
                <select name="parent" class="form-control">
                    <option value="none">Нет</option>
                    @foreach (\App\Models\categories::all() as $cat)
                        <option value="{{ $cat->id }}"
                        @if (isset($_SESSION['current_category']))
                            @if ($cat->id == $_SESSION['current_category'])
                                selected
                            @endif
                        @endif
                        >
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <p>Название категории:</p>
                <input type="text" name="name" class="form-control" required>
                @include('includes.controls.upload-file')
                @include('includes.controls.site-images')
                <input type="hidden" name="image_id">
                <div class="center"><input type="submit" value="Создать" class="btn btn-primary w-50"></div>
            </form>
            <script>
                $(document).ready(function(){
                    $('form').submit(function(e){
                        if ($('input[name=name]').val().trim() == '' ||
                            $('.image-gallery').prop('data-id') == null ||
                            $('.image-gallery').prop('data-id') == undefined){
                            e.preventDefault();
                        } else if ($(':invalid').length != 0){
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
