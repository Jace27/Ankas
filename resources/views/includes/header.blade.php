@section('header')
    <header class="b-white">
        <div class="logo"><a href="{{ route('main-page') }}"><img src="/images/logo.svg"></a></div>
        <div class="phone mobile-hidden"><span>+7(351) 751-40-12</span></div>
        <div class="search micon">
            <form action="{{ route('search') }}" method="post" enctype="multipart/form-data" id="search-form">
                @csrf
                <input type="text" name="search" placeholder="Искать" class="search-input d-none">
            </form>
        </div>
        <div class="cart micon">&nbsp;</div>
        <script>
            $(document).ready(function(){
                $('.search').click(function(e){
                    if (!$(e.target).hasClass('search-input')) {
                        if (!$('.logo').hasClass('d-none')) {
                            $('.logo').addClass('d-none');
                            $('.search-input').removeClass('d-none');
                            $('.search-input').focus();
                        } else {
                            $('.logo').removeClass('d-none');
                            $('.search-input').addClass('d-none');
                            $('#search-form').submit();
                        }
                    }
                });
                $('.cart').click(function(e){
                    window.location.assign('{{ route('cart') }}');
                });
            });
        </script>
    </header>
