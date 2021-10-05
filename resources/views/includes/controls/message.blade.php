<div class="modal" tabindex="-1" role="dialog" id="message_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">ОК</button>
            </div>
        </div>
    </div>
</div>
<script>
    function display_message(header, message) {
        if (header == '')
            $('#message_modal .modal-header').css('display', 'none');
        else
            $('#message_modal .modal-header').css('display', 'flex');
        $('#message_modal .modal-title').html(header);
        $('#message_modal .modal-body').html(message);
        $('#message_modal').modal('show');
    }
</script>
