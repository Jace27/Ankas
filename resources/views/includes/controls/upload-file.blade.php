<p>Изображение категории:</p>
<div class="file-dropper">
    <div class="center fs-20 va-center">Загрузить изображение</div>
</div>
<script>
    $(document).ready(function(){
        $('.file-dropper').click(function(){
            let file = document.createElement('input');
            file.type = 'file';
            file.accept = 'image/*';
            file.style.display = 'none';
            document.body.append(file);
            file.click();
            file.onchange = function(e){
                if (file.files.length > 0)
                    upload_file(file.files[0]);
                file.remove();
            }
        });
        $('.file-dropper').on('dragover', function(e){
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'copy';
            return false;
        });
        $('.file-dropper').on('drop', function(e){
            e.preventDefault();
            console.log(e);

            if (e.originalEvent.dataTransfer.files != null && e.originalEvent.dataTransfer.files.length > 0){
                upload_file(e.originalEvent.dataTransfer.files[0]);
            }
        });
    });

    function upload_file(file){
        let data = new FormData();
        data.append('file', file);
        data.append('destination', 'categories');
        $.ajax({
            url: '/api/image/upload',
            method: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(data, status, xhr){
                console.log(xhr);
                if (xhr.responseJSON != null && data.status == 'success'){
                    if (xhr.responseJSON != null && data.status == 'success')
                        reload_image_gallery();
                } else {
                    console.log(data);
                }
            },
            error: function(xhr){
                console.log(xhr);
            }
        });
    }
</script>
