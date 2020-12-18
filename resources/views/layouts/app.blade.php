<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield('head-title')</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/css/app.css?v=<?php echo rand(); ?>">
    <link rel="icon" href="/images/favicon.png">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/scripts.js"></script>
    @include('includes.head')
</head>
<body>
<div class="container">

    @include('includes.header')

    @yield('content')

    @include('includes.categories')

    @include('includes.footer')

</div>
</body>
</html>
