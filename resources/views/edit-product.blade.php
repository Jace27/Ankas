@extends('layouts.public')

@section('head')
    @parent
    <style>
        .b-white > div {
            padding: 1em;
        }
        input, select, textarea {
            display: block;
            margin: 0.5em;
            padding: 0.5em;
            width: calc(100% - 2em) !important;
            max-width: calc(100% - 2em) !important;
            box-sizing: content-box;
        }
        textarea {
            height: 150px;
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
    Изменить товар - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    @php
    $prod = \App\Models\products_detail::find($id);
    @endphp

    <div class="b-white p-1">
        <h1 class="page_header">Изменить товар {{ $prod->name }}</h1>

        <div>
            <form name="new-category" action="/products/edit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $id }}" name="id" class="form-control">
                <p>Название товара:</p>
                <input type="text" name="name" value="{{ $prod->name }}" class="form-control" required>
                <p>Артикул:</p>
                <input type="text" name="vendor" value="{{ $prod->vendor_code }}" class="form-control" required>
                <p>Цена:</p>
                <input type="number" value="{{ $prod->price }}" name="price" class="form-control" required min="0" step="0.01">
                <!--<select name="cy" class="form-control">
                    @foreach (\App\Models\cys::all() as $cy){
                        <option value="{{ $cy->id }}" @if ($cy->id == $prod->cy_id) selected @endif>
                            {{ $cy->symbol }}
                        </option>
                    @endforeach
                </select>-->
                <p>Производитель:</p>
                <select name="brand_id" class="form-control">
                    @foreach (\App\Models\brands::all() as $brand)
                        <option value="{{ $brand->id }}" @if ($brand->id == $prod->brand_id) selected @endif>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                <p>Модель:</p>
                <input type="text" name="model" value="{{ $prod->model }}" class="form-control">
                <p>Краткое описание:</p>
                <textarea name="desc_short" class="form-control">{{ $prod->description_short }}</textarea>
                <p>Полное описание:</p>
                <textarea name="desc" id="desc">{{ $prod->description }}</textarea>
                @include('includes.controls.upload-file')
                @include('includes.controls.site-images')
                <input type="hidden" name="image_id" class="form-control">
                <!--<p>Длина:</p>
                <input type="number" value="{{ $prod->length }}" name="length" class="form-control">
                <p>Ширина:</p>
                <input type="number" value="{{ $prod->width }}" name="width" class="form-control">
                <p>Высота:</p>
                <input type="number" value="{{ $prod->height }}" name="height" class="form-control">
                <p>Вес:</p>
                <input type="number" value="{{ $prod->weight }}" name="weight" class="form-control">-->
                <div class="center">
                <input type="submit" value="Сохранить изменения" class="btn btn-primary">
                </div>
            </form>
            <script>
                $(document).ready(function(){
                    tinymce.init({
                        selector: 'textarea#desc',
                        <?php echo \App\Settings::$tinymce_settings; ?>
                    });

                    $('form').submit(function(e){
                        if ($(':invalid').length > 0 ||
                            $('input[name=vendor]').val().trim() == '' ||
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
