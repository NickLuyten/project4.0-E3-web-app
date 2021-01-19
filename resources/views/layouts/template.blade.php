<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons//favicon-16x16.png">
    <link rel="manifest" href="/assets/icons//site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('css_after')
    <title>@yield('title', 'The Vinyl Shop')</title>
</head>
<body>
{{--  Navigation  --}}
@include('shared.navagation')
<main class="container">
    @if (trim($__env->yieldContent('title')))
        <h1 class="text-primary">EXAMEN/@yield('title', 'The Vinyl Shop')</h1>
    @endif
    @yield('main', 'Page under construction ...')

</main>
{{--  Footer  --}}
@include('shared.footer')
<script src="{{ mix('js/app.js') }}"></script>
@yield('script_after')
@if(env('APP_DEBUG'))
    <script>
        $('form').attr('novalidate', 'true');
    </script>
@endif
</body>
</html>
