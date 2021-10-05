@extends('layouts.public')

@section('head')
    @parent
@endsection

@section('head-title')
    Все заказы - Ankas
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1 class="page_header">Все заказы</h1>

        <div class="orders"></div>
    </div>
@endsection

@section('footer')
    @parent
    <script>
        $(document).ready(function(){
            search_orders('<?php if(isset($_GET['search'])){ echo $_GET['search']; } ?>');
            $('#search-form [name=search]').on('input', function (e) {
                search_orders($(this).val());
            });
            $('#search-form').unbind('submit');
            $('#search-form').submit(function(e){
                e.preventDefault();
            });

            @if(isset($_GET['search']))
                $('#search-form [name=search]').val('{{ $_GET['search'] }}');
                $('.search').click();
            @endif
        });

        function search_orders(search){
            let data = new FormData();
            data.append('search', search);
            $.ajax({
                url: '/api/orders/search<?php if(isset($_GET['page'])){ echo '?page='.$_GET['page']; } ?>',
                method: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function(data, status, xhr){
                    $('.orders').html(data);
                }
            })
        }
    </script>
@endsection
