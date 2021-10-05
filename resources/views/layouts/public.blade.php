@php
if(!isset($_SESSION)) session_start();
@endphp
<!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
<div class="container">

    @include('includes.header')

    @yield('content')

    @include('includes.footer')

    @if(!isset($_SESSION['AuthedUser']) ||
        (\App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first() != null &&
        \App\Models\users::where('email', '=', $_SESSION['AuthedUser']['email'])->first()->role()->first()->name == 'Клиент'))
        @include('includes.controls.chat')
    @endif
</div>
</body>
</html>
