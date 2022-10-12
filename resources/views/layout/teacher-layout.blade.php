<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>teacher-layout</title>

    {{-- app style --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- layout css --}}
    <link rel="stylesheet" href="{{ asset('css/teacher-layout.css') }}">

    {{-- page style --}}
    @yield('page_style')
</head>

<body>

    {{-- side bar --}}

    <div class="sidebar-wrapper collapsed">
        <nav class="sidebar">
            <ul>
                <li>
                    <a href="#">Classes</a>
                    <a href="#">Classes</a>
                    <a href="#">Classes</a>
                    <a href="#">Classes</a>
                    <a href="#">Classes</a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- nav --}}
    <nav class="header-nav">

        {{-- header menu --}}
        <button type="button" class="header-menu">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" id="footer-sample-full" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" class="iconify iconify--charm">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5"></path>
            </svg>
        </button>

        {{-- header brand --}}
        <h2 class="header-brand">
            <img src="{{ asset('img/logo.png') }}" alt="">
            iLearning
        </h2>

        {{-- add class button --}}
        @if (Request::is('teacher/classes'))
            <button type="button" class="add-class-button button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 20v-8m0 0V4m0 8h8m-8 0H4" />
                </svg>
            </button>
        @endif

        {{-- account menu --}}
        <div class="account-menu">
            <a href="/teacher/logout">
                {{ Auth::guard('teacher')->user()->lastname }},
                {{ Auth::guard('teacher')->user()->firstname }}
                @if ($m = Auth::guard('teacher')->user()->middlename)
                    {{ $m[0] . '.' }}
                @endif
            </a>
        </div>

    </nav>


    {{-- page content --}}
    <div class="content">
        @yield('page_content')
    </div>

    {{-- app js --}}
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.header-menu').on('click', function() {
            $('.sidebar-wrapper').removeClass('collapsed');
        })


        $('.sidebar-wrapper').on('click', function() {
            $(this).addClass('collapsed');
        })

        $('.sidebar-wrapper *').on('click', function(e) {
            e.stopPropagation();
        });
    </script>

    {{-- page script --}}
    @yield('page_script')
</body>

</html>
