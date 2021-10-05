@section('head')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=0.7">
    <title>@yield('head-title')</title>
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/css/bootstrap/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/css/slider.css">
    <link rel="stylesheet" href="/css/app.css?v={{ rand() }}">
    <link rel="stylesheet" href="/css/classes.css?v={{ rand() }}">
    <link rel="stylesheet" href="/css/special.css?v={{ rand() }}">
    <link rel="stylesheet" href="/css/popup.css?v={{ rand() }}">
    <link rel="icon" href="/images/favicon.png">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/bootstrap/bootstrap.min.js"></script>
    <script src="/js/tinymce/tinymce.min.js"></script>
    <script src="/js/app.js"></script>
    @show
