<div class="modal" tabindex="-1" role="dialog" id="confirmation_modal">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary btn-confirmation-ok">Подтвердить</button>
            </div>
        </div>
    </div>
</div>
<script>
    function request_confirmation(header, message, callback){
        $('#confirmation_modal .modal-title').html(header);
        $('#confirmation_modal .modal-body').html(message);
        $('#confirmation_modal').modal('show');
        $('.btn-confirmation-ok').unbind('click');
        $('.btn-confirmation-ok').click(function(){
            callback();
            $('#confirmation_modal').modal('hide');
        });
    }
</script>
