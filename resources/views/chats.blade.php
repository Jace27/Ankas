@extends('layouts.public')

@section('head')
    @parent
    <style>
        .bg-secondary {
            background-color: #aaa !important;
        }
    </style>
@endsection

@section('head-title')
    Общение с клиентами
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="b-white p-1">
        <h1>Общение с клиентами</h1>
    </div>
    <div class="b-white pt-2 pb-2">
        <div id="chats"></div>
    </div>
    <script>
        $(document).ready(function(){
            load_chats();
            setInterval(load_chats, {{ \App\Settings::$chat_reload_interval }});
        });
        function load_chats(){
            $.ajax({
                url: '/api/message/get/chats',
                method: 'get',
                data: null,
                contentType: false,
                processData: false,
                success: function(data, status, xhr){
                    console.log(xhr);
                    if (xhr.responseJSON != null){
                        $('#chats').html('');
                        data.forEach(function(item, index, array){
                            let viewed = '';
                            if (item.viewed == 0) viewed = ' bg-secondary';
                            $('#chats').append('<div data-chat-id="' + item.chat_id + '" class="d-flex flex-row align-center pl-3 pr-3 pt-2 pb-2 border cursor-pointer chat' + viewed + '"><div class="d-flex flex-row align-center justify-content-center" style="width: 40px; height: 40px; border: 1px solid black; border-radius: 50%; font-size: 1.6em; padding-top: calc(20px - 1em); padding-left: calc(20px - 1em); margin: 0 1rem;"><span>' + item.chat_id + '</span></div><p style="margin: calc(20px - 0.7rem) 0 0 0">' + item.message + '</p></div>');
                        });
                        reset_handlers();
                    } else {
                        display_message('Загрузка списка чатов', 'Ошибка!<br>'+data.message);
                    }
                },
                error: function(xhr){
                    console.log(xhr);
                }
            });
        }
        function reset_handlers(){
            $('.chat').click(function(){
                window.location.assign('/chat/' + this.dataset.chatId);
            });
        }
    </script>
@endsection

@section('footer')
    @parent
@endsection
