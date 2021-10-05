<div class="chat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Чат с менеджером</h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer bg-gray">
                <input type="text" class="form-control" placeholder="Ваш вопрос">
                <button type="button" class="btn btn-primary btn-chat-send-message">Отправить</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.chat .modal-header').click(function () {
            if ($('.chat .modal-dialog').css('margin-top') == '637px')
                $('.chat .modal-dialog').css('margin', '0');
            else
                $('.chat .modal-dialog').css('margin', 'calc(700px - 63px) 0 0 0');
        });

        chat_load_messages();
        setInterval(chat_load_messages, {{ \App\Settings::$chat_reload_interval }});

        $('.chat input[type=text]').keydown(function(e){
            if (e.keyCode === 13) chat_send_message();
        });
        $('.btn-chat-send-message').click(function () {
            chat_send_message();
        });
    });

    function chat_load_messages() {
        let chat_id = 0;
        if (localStorage.getItem('chat_id') !== null)
            if (Number.isInteger(+localStorage.getItem('chat_id')))
                chat_id = +localStorage.getItem('chat_id');
        $.ajax({
            url: '/api/message/get/chat/' + chat_id,
            method: 'get',
            data: null,
            contentType: false,
            processData: false,
            success: function(data, status, xhr){
                console.log(xhr);
                if (xhr.responseJSON != null){
                    localStorage.setItem('chat_id', data.chat_id);
                    $('.chat .modal-body').html('');
                    data.messages.forEach(function(item, index, array){
                        let viewed = '';
                        if (item.viewed == 0) viewed = ' class="bg-light"';
                        $('.chat .modal-body').append('<p' + viewed + '><span class="font-weight-bold">' + item.user + ': </span><br>' + item.text + '</p>');
                    });
                    $('.chat .modal-body').animate({ scrollTop: $('.chat .modal-body')[0].scrollHeight }, 200);
                } else {
                    display_message('Загрузка сообщений', 'Ошибка!<br>'+data.message);
                }
            },
            error: function(xhr){
                console.log(xhr);
            }
        });
    }
    function chat_send_message() {
        if ($('.chat input[type=text]').val().trim() == '') return;

        let chat_id = 0;
        if (localStorage.getItem('chat_id') !== null)
            if (Number.isInteger(+localStorage.getItem('chat_id')))
                chat_id = +localStorage.getItem('chat_id');
        let data = new FormData();
        @php
            $user = 'null';
            if (isset($_SESSION['AuthedUser'])) $user = $_SESSION['AuthedUser']['email'];
        @endphp
        data.append('user', '{{ $user }}');
        data.append('chat_id', chat_id);
        data.append('text', $('.chat input[type=text]').val().trim());
        $.ajax({
            url: '/api/message/add',
            method: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(data, status, xhr){
                console.log(xhr);
                if (xhr.responseJSON != null && data.status == 'success'){
                    chat_load_messages();
                    $('.chat input[type=text]').val('');
                } else {
                    display_message('Отправка сообщения', 'Ошибка!<br>'+data.message);
                }
            },
            error: function(xhr){
                console.log(xhr);
            }
        });
    }
</script>
