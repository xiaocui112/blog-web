<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','博客')-分享</title>
<meta name="description" content="@yield('description', 'php 爱好者社区')"
    <!-- Scripts -->
  
    @yield('styles')
 
    <!-- Fonts -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="{{route_class()}}-page">
        @include('layouts._header')
        <div class="container">
            @include('shared._messages')
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    <script src="{{ asset('js/app.js') }}" ></script>
    @yield('scripts')
</body>
</html>
