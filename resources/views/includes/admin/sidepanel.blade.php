<div class="col-2 bg-dark p-3 h-100">
    <div class="logo ml-3"><a href="{{ route('main-page') }}"><img src="/images/logo.svg"></a></div>
    <hr>
    <ol class="nav flex-column">
        <li class="nav-item p-3 rounded text-white cursor-pointer" onclick="window.location.assign('{{ route('admin-products') }}')">Товары</li>
        <li class="nav-item p-3 rounded text-white cursor-pointer" onclick="window.location.assign('{{ route('admin-orders') }}')">Заказы</li>
@if(isset($_SESSION['AuthedUser']) &&
                ($_SESSION['AuthedUser']['role'] != 'Редактор'))
        <li class="nav-item p-3 rounded text-white cursor-pointer" onclick="window.location.assign('{{ route('admin-users') }}')">Пользователи</li>
@endif
    </ol>
</div>
