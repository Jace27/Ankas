@php
    if(!isset($_SESSION)) session_start();
@endphp
<!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body style="overflow: hidden">
<div class="row h-100">
    @include('includes.admin.sidepanel')

    <div class="col-10 p-2">
        @yield('content')
    </div>
</div>

<script src="/js/admin.js?v={{ rand() }}"></script>

@include('includes.controls.confirmation')
@include('includes.controls.message')

</body>
</html>
