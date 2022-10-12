<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('APP_NAME'))</title>

    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/png">


    {{-- app style --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- roboto --}}
    <link rel="preload" href="{{ asset('font/roboto-v30-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- fontawesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    {{-- layout style --}}
    <link rel="stylesheet" href="{{ asset('css/administrator-layout.css') }}">

    @yield('page_style')
</head>

<body>
    <x-administration-nav />

    <div class="toast-wrapper">
        @if (Session::has('toast'))
            <div class="toast toast-{{ Session::get('toast')['type'] }}">
                {{ Session::get('toast')['message'] }}
                <button type="button">&times;</button>
            </div>
        @endif
    </div>

    @yield('page_content')

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.toast>button').on('click', function() {
            $(this).parent().fadeOut(300);
        })
    </script>
    @yield('nav_script')
    @yield('page_script')
</body>

</html>
