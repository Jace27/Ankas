let old_value, current_element;

$(document).ready(function(){
    $('.edit').css('display', 'none');

    $('.btn-delete-selected').click(function () {
        let elems = $('input[type=checkbox]:checked');
        let table = $(elems[0]).parent().parent().parent().parent()[0].dataset.table;
        let ids = [];
        elems.each(function(index, elem){
            ids[ids.length] = $(elem).parent().parent()[0].dataset.id;
        });

        request_confirmation('Удаление', 'Вы действительно хотите удалить выбранные элементы?', function(){
            delete_data(table, ids, function(){
                window.location.reload();
            });
        });
    });

    $('th').click(function(){
        if ($(this).attr('data-sortby') !== undefined){
            let sortby = $(this).attr('data-sortby');
            if (sortby == 'none') {
                window.location.assign(window.location.pathname);
                return;
            }
            let wl = window.location;
            let search = '';
            if (wl.search != '') {
                search = wl.search.split('?')[1];
                search = search.split('&');
                search.forEach(function (elem, index, array) {
                    array[index] = elem.split('=');
                });
                search.forEach(function (elem, index, array) {
                    if (elem[0] == 'mode') {
                        if (elem[1] == 'desc') elem[1] = 'asc';
                        else
                        if (elem[1] == 'asc') elem[1] = 'desc';
                    }
                    if (elem[0] == 'sortby') elem[1] = sortby;
                });
                search.forEach(function (elem, index, array) {
                    search[index] = elem.join('=');
                });
                search = search.join('&');
            } else {
                search = 'sortby='+sortby+'&mode=asc';
            }
            window.location.assign(wl.pathname + '?'+search);
        }
    });

    $('input[type=checkbox]').change(function(){
        if ($('input[type=checkbox]:checked').length > 0){
            $('.btn-delete-selected').prop('disabled', false);
        } else {
            $('.btn-delete-selected').prop('disabled', true);
        }
    });

    $('.view').click(function(e){
        if (e.target.nodeName == 'DIV') {
            $('.edit').css('display', 'none');
            $('.view').css('display', 'block');
            $(this).next('.edit').css('display', 'block');
            $(this).css('display', 'none');
        }
    });
    $('.edit').click(function(e){
        if (e.target.nodeName == 'DIV') {
            if ($(this).find(':invalid').length > 0) return;
            let elem = this;
            let table = $(elem).parent().parent().parent().parent()[0].dataset.table;
            let id = $(elem).parent().parent()[0].dataset.id;
            let field = $(elem).parent()[0].dataset.field;
            let value = $(elem).children('[name='+field+']').val().trim();
            update_data(table, id, field, value, function(){
                $(elem).prev('.view').css('display', 'block');
                $(elem).css('display', 'none');
                if ($(elem).children('[name='+field+']')[0].nodeName == 'INPUT')
                    $(elem).prev('.view').html(value);
                else if ($(elem).children('[name='+field+']')[0].nodeName == 'SELECT')
                    $(elem).prev('.view').html($(elem).children('[name='+field+']')[0].selectedOptions[0].label);
                $(elem).children('[name='+field+']').val(value);

                if (field == 'description'){
                    field = 'description_short';
                    value = $(elem).children('[name='+field+']').val().trim();
                    update_data(table, id, field, value, function(){});
                }
            });
        }
    });

    $('select').on('focus', function(){
        current_element = this;
        old_value = $(this).val();
    });
    $('input').on('focus', function(){
        current_element = this;
        old_value = $(this).val();
    });
});

function update_data(table, id, field, value, callback){
    let data = new FormData();
    data.append('table', table);
    data.append('id', id);
    data.append('field', field);
    data.append('value', value);
    $.ajax({
        url: '/api/table/change',
        method: 'post',
        data: data,
        processData: false,
        contentType: false,
        success: function(data, status, xhr){
            console.log(xhr);
            if (xhr.responseJSON != null && data.status == 'success'){
                callback();
            } else {
                display_message('Изменение данных', 'Ошибка!<br>'+data.message);
                $(current_element).val(old_value);
            }
        },
        error: function(xhr){
            console.log(xhr);
        }
    });
}
function delete_data(table, ids, callback){
    let data = new FormData();
    data.append('table', table);
    data.append('ids', JSON.stringify(ids));
    $.ajax({
        url: '/api/table/delete',
        method: 'post',
        data: data,
        processData: false,
        contentType: false,
        success: function(data, status, xhr){
            console.log(xhr);
            if (xhr.responseJSON != null && data.status == 'success'){
                callback();
            } else {
                display_message('Удаление данных', 'Ошибка!<br>'+data.message);
            }
        },
        error: function(xhr){
            console.log(xhr);
        }
    });
}
