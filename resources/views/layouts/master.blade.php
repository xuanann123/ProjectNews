<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Hugo 0.74.3" />

    <!-- theme meta -->
    <meta name="theme-name" content="reader" />

    <!-- plugins -->
    <link rel="stylesheet" href="{{ url('theme/fontend/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('theme/fontend/plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ url('theme/fontend/plugins/slick/slick.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ url('theme/fontend/css/style.css') }}" media="screen">
    <!-- Đối với Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!--Favicon-->
    <link rel="shortcut icon" href="{{ url('theme/fontend/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('theme/fontend/images/favicon.png') }}" type="image/x-icon">
    <meta property="og:title" content="Reader | Hugo Personal Blog Template" />
    <meta property="og:description" content="This is meta description" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" />
</head>

<body>
    @include('layouts.header')


    @yield('content')

    @include('layouts.footer')x


    <!-- JS Plugins -->
    <script src="{{ url('theme/fontend/plugins/jQuery/jquery.min.js') }}"></script>

    <script src="{{ url('theme/fontend/plugins/bootstrap/bootstrap.min.js') }}"></script>

    <script src="{{ url('theme/fontend/plugins/slick/slick.min.js') }}"></script>

    <script src="{{ url('theme/fontend/plugins/instafeed/instafeed.min.js') }}"></script>


    <!-- Main Script -->
    <script src="{{ url('theme/fontend/js/script.js') }}"></script>
</body>

</html>
