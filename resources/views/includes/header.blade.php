@section('header')
    <header class="b-white">
        <div class="logo"><a href="{{ route('main-page') }}"><img src="/images/logo.svg"></a></div>
        <div class="phone mobile-hidden"><span>+7(351) 751-40-12</span></div>
        <div class="search micon">
            <form action="{{ route('search') }}" method="post" enctype="multipart/form-data" id="search-form">
                @csrf
                <input type="text" name="search" placeholder="Искать" class="search-input d-none" style="width: 0">
            </form>
        </div>
        <div class="cart micon">&nbsp;</div>
        <script>
            $(document).ready(function(){
                $('.search').click(function(e){
                    if (!$(e.target).hasClass('search-input')) {
                        if (!$('.logo').hasClass('d-none')) {
                            $('.logo').css('width', 0);
                            $('.logo').css('min-width', 0);
                            $('.logo').css('padding', '1em 0');
                            $('.search-input').removeClass('d-none');
                            $('.search-input').animate({ width: '100%' }, 500, 'linear');
                            $('.search-input').focus();
                            setTimeout(function(){ $('.logo').addClass('d-none'); }, 500);
                        } else {
                            $('.logo').removeClass('d-none');
                            $('.logo').animate({ width: 150, minWidth: 150, padding: '1em' }, 500, 'linear');
                            $('.search-input').css('width', 0);
                            setTimeout(function(){ $('.search-input').addClass('d-none'); }, 500);
                            $('#search-form').submit();
                        }
                    }
                });
                $('.cart').click(function(e){
                    window.location.assign('{{ route('cart') }}');
                });
                $('#search-form').on('submit', function(e){
                    if ($('.search-input').val().trim() == '')
                        e.preventDefault();
                });
            });
        </script>
    </header>
