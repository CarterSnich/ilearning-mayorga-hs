<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iLearning - Mayorga National High School</title>

    {{-- fonts --}}
    <link rel="preload" href="{{ asset('font/roboto-v30-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('font/material-icons-outlined.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- app style --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- index style --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>

<body>

    <div class="toast-wrapper">
        @if (Session::has('toast'))
            <div class="toast toast-{{ Session::get('toast')['type'] }}">
                {{ Session::get('toast')['message'] }}
                <button type="button">&times;</button>
            </div>
        @endif
    </div>

    <div id="main">
        <div class="logo-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="">
            <div>
                <h2>iLearning</h2>
                <h4>Mayorga National High School</h4>
            </div>
        </div>


        <div class="signin-wrapper">

            <div class="signin-buttons">
                <h2>Sign in As</h2>
                <div class="button-group">
                    <button @unless(request()->get('t') == 'student') class="active" @endunless data-form-target="teacher">Teacher</button>
                    <button @if (request()->get('t') == 'student') class="active" @endif data-form-target="student">Student</button>
                </div>
            </div>


            <div class="signin-forms">

                {{-- teacher signin form --}}
                <form action="/teacher/login/authenticate" method="POST" data-form-for="teacher" @if (request()->get('t') == 'student') style="display: none" @endif>
                    @csrf

                    @error('teacher_login')
                        <div class="login-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-fields">
                        {{-- teacher id --}}
                        <div class="input-floating">
                            <input type="text" name="teacher_id" id="teacher-id" placeholder=" ">
                            <label for="teacher-id">Teacher ID</label>
                        </div>
                        {{-- password --}}
                        <div class="input-floating">
                            <input type="password" name="teacher_password" id="teacher_password" placeholder=" ">
                            <label for="teacher_password">Password</label>
                        </div>
                    </div>


                    <button type="submit">SIGN IN</button>

                    <div class="bottom-links">
                        <a href="/student/recovery">Recover password</a>
                    </div>

                </form>

                {{-- student signin form --}}
                <form data-form-for="student" method="POST" action="/student/login/authenticate" @unless(request()->get('t') == 'student') style="display: none" @endunless>
                    @csrf

                    @error('student_login')
                        <div class="login-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="input-fields">
                        {{-- username --}}
                        <div class="input-floating">
                            <input type="text" name="username" id="student-username" placeholder=" ">
                            <label for="student-username">Student ID</label>
                        </div>

                        {{-- password --}}
                        <div class="input-floating">
                            <input type="password" name="password" id="student-password" placeholder=" ">
                            <label for="student-password">Password</label>
                        </div>
                    </div>

                    <button type="submit">SIGN IN</button>

                    <div class="bottom-links">
                        <a href="/student/recovery">Recover password</a>
                        <a href="/student/email-signup">Sign up here</a>
                    </div>

                </form>

            </div>

        </div>

    </div>



    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.toast>button').on('click', function() {
            $(this).parent().fadeOut(300);
        })

        $('.signin-buttons button').on('click', function() {
            let formTarget = $(this).addClass('active').siblings().removeClass('active').attr('data-form-target')
            $(`form[data-form-for=${formTarget}]`).hide().siblings().fadeIn()
            $('form :input:not([type=hidden])').val('')
        })
    </script>

</body>

</html>
