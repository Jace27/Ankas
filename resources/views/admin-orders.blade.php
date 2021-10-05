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
    <h1 class="p-2">Заказы</h1>
    <div style="overflow: auto; max-width: calc(100% - 1rem); margin-bottom: 1rem">
        <div class="b-white p-2">
            <button disabled class="btn btn-outline-danger btn-delete-selected">Удалить выбранное</button>
        </div>
        @php
        if ($mode == null) $mode = 'asc';
        $items = \App\Models\orders::where('id', '>', 0);
        if ($sortby == 'status'){
        	$items = \App\Models\orders::join('order_statuses', 'status_id', '=', 'order_statuses.id')->orderBy('order_statuses.name', $mode)->with('status');
        }
        else
        if($sortby != null){
            $items = \App\Models\orders::orderBy($sortby, $mode);
        }
        @endphp
        <table class="table table-active table-striped mb-1 fs-14" data-table="orders">
            <tbody>
                <tr>
                    <th data-sortby="none"></th>
                    <th data-sortby="last_name">Фамилия @if($sortby == 'last_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="first_name">Имя @if($sortby == 'first_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="third_name">Отчество @if($sortby == 'third_name') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="phone">Телефон @if($sortby == 'phone') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="email">E-Mail @if($sortby == 'email') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="status">Статус @if($sortby == 'status') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th data-sortby="created_at">Добавлено @if($sortby == 'created_at') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif</th>
                    <th data-sortby="updated_at">Изменено @if($sortby == 'updated_at') @if($mode == 'desc') &#8593; @else &#8595; @endif @endif&nbsp;&nbsp;</th>
                </tr>
                @php $paginator = $items->paginate(12, ['*'], 'page'); @endphp
                @foreach($paginator as $order)
                    <tr data-id="{{ $order->id }}">
                        <td><input type="checkbox"></td>
                        <td data-field="last_name">
                            <div class="view">{{ $order->last_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="last_name" value="{{ $order->last_name }}" required>
                            </div>
                        </td>
                        <td data-field="first_name">
                            <div class="view">{{ $order->first_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="first_name" value="{{ $order->first_name }}" required>
                            </div>
                        </td>
                        <td data-field="third_name">
                            <div class="view">{{ $order->third_name }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="third_name" value="{{ $order->third_name }}">
                            </div>
                        </td>
                        <td data-field="phone">
                            <div class="view">{{ $order->phone }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="phone" value="{{ $order->phone }}" pattern="^((8|\+(\d{1,5}))[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$" minlength="7" maxlength="22" required>
                            </div>
                        </td>
                        <td data-field="email">
                            <div class="view">{{ $order->email }}&nbsp;</div>
                            <div class="edit">
                                <input type="text" class="form-control" name="email" value="{{ $order->email }}" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                            </div>
                        </td>
                        <td data-field="status_id">
                            <div class="view">{{ $order->status()->first()->name }}&nbsp;</div>
                            <div class="edit">
                                <select name="status_id" class="form-control">
                                    @foreach(\App\Models\order_statuses::all() as $status)
                                        <option
                                            value="{{ $status->id }}"
                                            @if($status->id == $order->status()->first()->id) selected @endif>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td data-field="created_at" style="word-wrap: normal">{{ $order->created_at }}</td>
                        <td data-field="updated_at" style="word-wrap: normal">{{ $order->updated_at }}</td>
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
@endsection
