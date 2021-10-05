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
    Создать товар - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">Создать новый товар</h1>

        <div>
            <form name="new-category" action="{{ route('add-product') }}" method="post" enctype="multipart/form-data">
                @csrf
                <p>Категория:</p>
                <select name="category" class="form-control">
                    <option value="none">Нет</option>
                    @foreach (\App\Models\categories::all() as $cat){
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
                <p>Название товара:</p>
                <input type="text" name="name" class="form-control" required>
                <p>Артикул:</p>
                <input type="text" name="vendor" class="form-control" required>
                <p>Цена:</p>
                <input type="number" value="0.00" name="price" class="form-control" required min="0" step="0.01">
                <!--<select name="cy" class="form-control">
                    @foreach (\App\Models\cys::all() as $cy)
                        <option value="{{ $cy->id }}">{{ $cy->symbol }}</option>
                    @endforeach
                </select>-->
                <p>Производитель:</p>
                <select name="brand_id" class="form-control">
                    @foreach (\App\Models\brands::all() as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <p>Модель:</p>
                <input type="text" name="model" class="form-control">
                <p>Краткое описание:</p>
                <textarea name="desc_short" class="form-control"></textarea>
                <p>Полное описание:</p>
                <textarea name="desc" id="desc" style="transition: 0s linear"></textarea>
                @include('includes.controls.upload-file')
                @include('includes.controls.site-images')
                <input type="hidden" name="image_id">
                <!--<p>Длина:</p>
                <input type="number" value="0" name="length" class="form-control">
                <p>Ширина:</p>
                <input type="number" value="0" name="width" class="form-control">
                <p>Высота:</p>
                <input type="number" value="0" name="height" class="form-control">
                <p>Вес:</p>
                <input type="number" value="0" name="weight" class="form-control">-->
                <div class="center"><input type="submit" value="Создать" class="w-25 btn btn-primary"></div>
            </form>
            <script>
                $(document).ready(function(){
                    tinymce.init({
                        selector: 'textarea#desc',
                        <?php echo \App\Settings::$tinymce_settings; ?>
                    });

                    $('form').submit(function(e){
                        if ($('input[name=name]').val().trim() == '' ||
                            $('input[name=vendor]').val().trim() == '' ||
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
