@extends('layouts.admin')

@section('head')
    @parent
    <style>
        td {
            padding: 0.25rem !important;
        }
        th[data-sortby] {
            cursor: pointer;
            white-space: nowrap;
        }
        .view {
            padding: 0.25rem;
            margin: -0.25rem;
            min-height: 30px;
            cursor: pointer;
        }
        .edit {
            padding: 0.75rem;
            cursor: pointer;
        }
        :invalid {
            background-color: rgba(220,53,69,0.1);
        }
    </style>
@endsection

@section('head-title')
    Панель управления
@endsection

@section('content')
    <h1 class="p-2">Товары</h1>
    <div style="overflow: auto; max-width: calc(100% - 1rem); margin-bottom: 1rem">
        <div class="b-white p-2">
            <button disabled class="btn btn-outline-danger btn-delete-selected">Удалить выбранное</button>
            <button class="btn btn-outline-primary" onclick="window.location.assign('/products/add')">Добавить</button>
        </div>
        @php
        if ($mode == null) $mode = 'asc';
        $items = \App\Models\products_detail::where('id', '>', 0);
        if ($sortby == 'brand'){
        	$items = \App\Models\products_detail::join('brands', 'brand_id', '=', 'brands.id')->orderBy('brands.name', $mode)->with('brand');
        }
        else
        if ($sortby == 'cy'){
        	$items = \App\Models\products_detail::join('cys', 'cy_id', '=', 'cys.id')->orderBy('cys.name', $mode)->with('cy');
        }
        else
        if($sortby != null){
            $items = \App\Models\products_detail::orderBy($sortby, $mode);
        }
        @endphp
        <table class="table table-active table-striped mb-1 fs-14" data-table="products_detail">
            <tbody>
                <tr>
                    <th data-sortby="none"></th>
                    <th>Категория</th>
                    <th data-sortby="vendor_code">Артикул @if($sortby == 'vendor_code') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="name">Название @if($sortby == 'name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="model">Модель @if($sortby == 'model') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="brand">Производитель @if($sortby == 'brand') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="price">Цена @if($sortby == 'price') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <!--<th data-sortby="cy">Валюта @if($sortby == 'cy') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>-->
                    <th>Описание</th>
                    <th>Изображение</th>
                    <th data-sortby="created_at">Добавлено @if($sortby == 'created_at') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="updated_at">Изменено @if($sortby == 'updated_at') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif&nbsp;&nbsp;</th>
                </tr>
                @php $paginator = $items->paginate(12, ['*'], 'page'); @endphp
                @foreach($paginator as $product)
                    <tr data-id="{{ $product->id }}">
                        <td><input type="checkbox"></td>
                        <td data-field="cat_id">
                            <div class="view">
                                @if($product->categories()->first() != null)
                                    {{ $product->categories()->first()->name }}&nbsp;
                                @else
                                    Нет категории
                                @endif
                            </div>
                            <div class="edit">
                                <select name="cat_id" class="form-control">
                                    <option value="0">Нет категории</option>
                                    @foreach(\App\Models\categories::all() as $cat)
                                        <option
                                            value="{{ $cat->id }}"
                                            @if($product->categories()->first() != null && $cat->id == $product->categories()->first()->id) selected @endif>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td data-field="vendor_code">
                            <div class="view">{{ $product->vendor_code }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="vendor_code" value="{{ $product->vendor_code }}" required>
                            </div>
                        </td>
                        <td data-field="name">
                            <div class="view">{{ $product->name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
                            </div>
                        </td>
                        <td data-field="model">
                            <div class="view">{{ $product->model }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="model" value="{{ $product->model }}">
                            </div>
                        </td>
                        <td data-field="brand_id">
                            <div class="view">{{ $product->brand()->first()->name }}&nbsp;</div>
                            <div class="edit">
                                <select name="brand_id" class="form-control">
                                    @foreach(\App\Models\brands::all() as $brand)
                                        <option
                                            value="{{ $brand->id }}"
                                            @if($brand->id == $product->brand()->first()->id) selected @endif>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td data-field="price">
                            <div class="view">{{ $product->price }}&nbsp;</div>
                            <div class="edit">
                                <input type="number" min="0" step="0.01" class="form-control" name="price" value="{{ $product->price }}">
                            </div>
                        </td>
                        <!--<td data-field="cy_id">
                            <div class="view">{{ $product->cy()->first()->name }}&nbsp;</div>
                            <div class="edit">
                                <select name="cy_id" class="form-control">
                                    @foreach(\App\Models\cys::all() as $cy)
                                        <option
                                            value="{{ $cy->id }}"
                                            @if($cy->id == $product->cy()->first()->id) selected @endif>
                                            {{ $cy->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>-->
                        <td data-field="description">
                            <button class="btn btn-secondary fs-12 btn-product-description-change">Изменить</button>
                            <div class="edit">
                                <textarea name="description_short" cols="30" rows="5"></textarea>
                                <textarea name="description" cols="30" rows="20"></textarea>
                            </div>
                        </td>
                        <td data-field="image_id">
                            <button class="btn btn-secondary fs-12 btn-product-image-change">Изменить</button>
                            <div class="edit">
                                <input type="number" name="image_id">
                            </div>
                        </td>
                        <td data-field="created_at" style="word-wrap: normal">{{ $product->created_at }}</td>
                        <td data-field="updated_at" style="word-wrap: normal">{{ $product->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($sortby != null)
        {{ $paginator->appends(['sortby'=>$sortby, 'mode'=>$mode])->links('vendor.pagination.bootstrap-4') }}
    @else
        {{ $paginator->links('vendor.pagination.bootstrap-4') }}
    @endif

    <div class="modal" tabindex="-1" role="dialog" id="description_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Описание товара</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Краткое описание:</b></p>
                    <textarea name="description_short" id="description_short" cols="30" rows="5" class="form-control"></textarea>
                    <br>
                    <p><b>Подробное описание:</b></p>
                    <textarea name="description" id="description" cols="30" rows="20"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary btn-product-description-change">Подтвердить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="image_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изображение товара</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('includes.controls.upload-file')
                    @include('includes.controls.site-images')
                    <input type="hidden" name="image_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary btn-product-image-change">Подтвердить</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let current_id = 0;
        $(document).ready(function(){
            tinymce.init({
                selector: '#description_modal [name=description]',
                <?php echo \App\Settings::$tinymce_settings; ?>
            });
            setInterval(function(){
                $('.image-gallery .hovering').each(function(index, elem) {
                    elem.className = 'col-4 hovering';
                });
            }, 500);

            $('table .btn-product-description-change').click(function(){
                $('#description_modal').modal('show');
                current_id = $(this).parent().parent()[0].dataset.id;
                get_descriptions(current_id);
            });
            $('#description_modal .btn-product-description-change').click(function(){
                $('tr').each(function(index1, elem1){
                    if (elem1.dataset.id == current_id){
                        $(elem1).children('td').each(function(index2, elem2){
                            if (elem2.dataset.field == 'description'){
                                $(elem2).children('.edit').children('[name=description]').val(tinymce.get('description').getContent());
                                $(elem2).children('.edit').children('[name=description_short]').val($('#description_modal [name=description_short]').val());
                                $(elem2).children('.edit').click();
                                $('#description_modal').modal('hide');
                                tinymce.get('description').setContent('');
                                $('#description_modal [name=description_short]').val('');
                            }
                        });
                    }
                });
            });

            $('table .btn-product-image-change').click(function(){
                $('#image_modal').modal('show');
                current_id = $(this).parent().parent()[0].dataset.id;
            });
            $('#image_modal .btn-product-image-change').click(function(){
                if ($('.image-gallery').prop('data-id') == null ||
                    $('.image-gallery').prop('data-id') == undefined){
                    return;
                }
                $('tr').each(function(index1, elem1){
                    if (elem1.dataset.id == current_id){
                        $(elem1).children('td').each(function(index2, elem2){
                            if (elem2.dataset.field == 'image_id'){
                                $(elem2).children('.edit').children('[name=image_id]').val($('.image-gallery').prop('data-id'));
                                $(elem2).children('.edit').click();
                                $('#image_modal').modal('hide');
                            }
                        });
                    }
                });
            });
        });

        function get_descriptions(prod_id){
            $.ajax({
                url: '/api/product/'+prod_id+'/get/descriptions',
                method: 'get',
                data: null,
                processData: false,
                contentType: false,
                success: function(data, status, xhr){
                    if (data.status == 'success'){
                        $('#description_modal [name=description]').val(data.description);
                        tinymce.get('description').setContent(data.description);
                        $('#description_modal [name=description_short]').val(data.description_short);
                    } else {
                        display_message('Описание товара', 'Ошибка!<br>'+data.message);
                        $('#description_modal').modal('hide');
                    }
                }
            })
        }
    </script>
@endsection
