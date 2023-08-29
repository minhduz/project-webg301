<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('asset/admin/css/bootstrap.min.css')}}" type="text/css">
    {{-- <link rel="stylesheet" href="{{asset('asset/client/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('asset/client/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('asset/client/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('asset/client/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('asset/client/css/slicknav.min.css')}}" type="text/css"> --}}
    <link rel="stylesheet" href="{{asset('asset/client/css/style_client.css')}}" type="text/css">

    @yield('sass')

</head>

<body>

    <!-- Humberger Begin -->
    @include('client.components.humberger')
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    @include('client.components.header')
    <!-- Header Section End -->

    @yield('hero')

    @yield('content')

    <!-- Footer Section Begin -->
    @include('client.components.footer')
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{asset('asset/client/js/mixitup.min.js')}}"></script>
    <script src="{{asset('asset/client/js/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
