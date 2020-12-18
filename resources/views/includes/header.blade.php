@section('header')
    <header class="b-white">
        <div class="logo"><a href="{{ route('main-page') }}"><img src="/images/logo.svg"></a></div>
        <div class="phone"><span>+7(351) 751-40-12</span></div>
        <div class="search micon"><input type="text" name="search" placeholder="Искать" class="search-input d-none"></div>
        <div class="cart micon">&nbsp;</div>
        <script>
            $(document).ready(function(){
                $('.search').click(function(e){
                    if (!$(e.target).hasClass('search-input')) {
                        if ($('.search > input').hasClass('d-none')) {
                            $('.search > input').removeClass('d-none');
                            $('.search > input').addClass('d-block');
                            $('.search > input').focus();
                        } else {
                            $('.search > input').removeClass('d-block');
                            $('.search > input').addClass('d-none');
                        }
                    }
                });
            })
        </script>
    </header>
