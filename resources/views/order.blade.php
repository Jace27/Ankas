@extends('layouts.public')

@section('head')
    @parent
    <style>
        .b-white > div {
            padding: 1em;
        }
    </style>
@endsection

@section('head-title')
    Заказ №{{ $id }} - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    @php
    $order = \App\Models\orders::find($id);
    @endphp

    <div class="b-white p-1">
        <h3 class="page_header">Заказ №{{ $order->id }}</h3>

        <div>
            <span><b>{{ $order->last_name }} {{ $order->first_name }} {{ $order->third_name }}</b></span><br>
            <span>E-Mail: {{ $order->email }}</span><br>
            <span>Телефон: {{ $order->phone }}</span><br>
            <span>Сумма: {{ $order->sum() }}</span><br>
            <span>Дата заказа: {{ $order->created_at }}</span><br>
            <span>Дата обновления состояния: {{ $order->updated_at }}</span><br>
            <span>
                <b>Статус:</b>
                @if (isset($_SESSION['AuthedUser']) &&
                     ($_SESSION['AuthedUser']['role'] == 'Администратор' || $_SESSION['AuthedUser']['role'] == 'Редактор'))
                    <form action="/orders/{{ $order->id }}/change" method="post" enctype="multipart/form-data">
                        @csrf
                        <select name="status_id" class="form-control w-25 d-inline-block">
                            <option disabled selected value="null">Выбрать...</option>
                            @foreach(\App\Models\order_statuses::all() as $status)
                                <option value="{{ $status->id }}" @if($status->id == $order->status()->first()->id) selected @endif>{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Обновить статус" class="btn btn-outline-primary d-inline-block">
                    </form>
                @else
                    <i>{{ $order->status()->first()->name }}</i>
                @endif
            </span>
            <hr>
            <span>Список товаров в заказе:</span>
            <table class="table border">
                <tbody>
                <tr>
                    <th>Название</th>
                    <th>Производитель</th>
                    <th>Цена</th>
                </tr>
                @foreach($order->products()->get() as $prod)
                    <tr>
                        <td>{{ $prod->name }}</td>
                        <td>{{ $prod->brand()->first()->name }}</td>
                        <td>{{ $prod->price() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
