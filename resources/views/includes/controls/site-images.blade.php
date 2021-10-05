<div class="image-gallery">
    <p>Доступные изображения:</p>
    <div class="row">
        @php $paginator = \App\Models\images::where('id', '<>', 1)->paginate(50, ['*'], 'image'); @endphp
        @foreach($paginator as $image)
            <div class="col-lg-2 col-md-4 col-sm-6 hovering">
                <img src="{{ $image->file_name }}" class="img-fluid rounded">
            </div>
        @endforeach
    </div>
    <!-- {{ $paginator->links('vendor.pagination.bootstrap-4') }} -->
</div>
<script>
    function reload_image_gallery(){
        $('.image-gallery').children('.row').html('<div class="col-12">Загрузка...</div>');
        $.ajax({
            url: '/api/images/all',
            method: 'get',
            contentType: false,
            processData: false,
            success: function(data, status, xhr){
                console.log(xhr);
                if (xhr.responseJSON != null){
                    $('.image-gallery').children('.row').html('');
                    xhr.responseJSON.forEach(function(item, index, array){
                        $('.image-gallery').children('.row').append('<div class="col-lg-2 col-md-4 col-sm-6 hovering" data-id="' + item.id + '"><img src="' + item.file_name + '" class="img-fluid rounded"></div>');
                    });
                    $('.image-gallery').children('.row').children('.hovering').click(function(e){
                        $('.image-gallery').children('.row').children('.hovering').removeClass('selected');
                        $(this).toggleClass('selected');
                        if ($(this).hasClass('selected'))
                            $('.image-gallery').prop('data-id', $(this)[0].dataset.id);
                        else
                            $('.image-gallery').prop('data-id', null);
                    });
                } else {
                    console.log(data);
                }
            },
            error: function(xhr){
                console.log(xhr);
            }
        })
    }
    $(document).ready(function(){
        reload_image_gallery();
    });
</script>
