<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iLearning - Mayorga National High School</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            display: flex;
            justify-content: center;
        }

        #main {
            display: grid;
            gap: 2.25rem;
            border: 1px solid var(--grey-color);
            padding: 1.25rem;
            margin-top: 5.25rem;
            margin-bottom: auto;
            border-radius: .25rem;
        }

        .logo-wrapper {
            display: flex;
            gap: 1.25rem;
            align-items: center
        }


        .logo-wrapper>img {
            width: 64px;
            height: 64px;
        }


        /* login wrapper */
        .login-wrapper {
            display: flex;
            flex-flow: column;
            gap: .75rem;
        }

        .login-buttons {
            display: flex;
            gap: 1.25rem;
            flex-flow: column
        }

        .login-wrapper>h2 {
            text-align: center
        }

        .login-wrapper form {
            display: grid;
            gap: 1.25rem;
            text-align: center
        }

        .login-wrapper form>div {
            display: flex;
            flex-flow: column;
            gap: .75rem
        }

        .login-wrapper button[type=submit] {
            border: 1px solid var(--grey-color);
            border-radius: .25rem;
            transition: all ease-in-out .3s;
            padding: 0.75rem;
        }

        .login-wrapper button[type=submit]:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-border);
            color: white;
        }

        .login-wrapper button[type=submit]:active {
            background-color: var(--primary-active);
        }

        .input-floating {
            position: relative;
        }

        .input-floating input {
            border: none;
            outline: none;
            height: 100%;
            width: 100%;
            z-index: 1;
            border: 1px solid var(--grey-color);
            border-radius: .25rem;
            padding-inline: .75rem;
            padding-block: 1.75rem .5rem;
        }

        .input-floating input:focus {
            border-color: var(--primary-color)
        }


        .input-floating label {
            position: absolute;
            font-size: large;
            top: 50%;
            left: .75rem;
            transform: translateY(-50%);
            transition: all ease-in-out .3s;
        }

        .input-floating input:focus+label,
        .input-floating input:not(:placeholder-shown)+label {
            transform: translateY(-100%);
            font-size: small;
            top: 40%;
        }

        .login-feedback {
            color: red;
            text-align: center;
            padding: .75rem 1.25rem;
            border: 1px solid red;
            border-radius: .25rem;
        }
    </style>

</head>

<body>

    @if (isset($data))
        @dd($data)
    @endif

    <div id="main">

        <div class="logo-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="">
            <div>
                <h2>iLearning</h2>
                <h4>Mayorga National High School</h4>
            </div>
        </div>

        <div class="login-wrapper">
            <h2>Administrator</h2>


            @foreach ($errors->all() as $message)
                <div class="login-feedback">
                    {{ $message }}
                </div>
            @endforeach
            <form data-form-for="teacher" action="/administration/login/authenticate" method="POST">
                @csrf
                <div>
                    {{-- username --}}
                    <div>
                        <div class="input-floating">
                            <input type="text" name="username" id="teacher-username" placeholder=" " value="{{ old('username') }}" required>
                            <label for="teacher-username">Username</label>
                        </div>
                    </div>

                    {{-- password --}}
                    <div>
                        <div class="input-floating">
                            <input type="password" name="password" id="teacher-password" placeholder=" " required>
                            <label for="teacher-password">Password</label>
                        </div>
                    </div>
                </div>

                <button type="submit">LOG IN</button>

            </form>

        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.login-buttons button').on('click', function() {
            let formTarget = $(this).addClass('active').siblings().removeClass('active').attr('data-form-target')
            $(`form[data-form-for=${formTarget}]`).hide().siblings().show()
            $('form :input').val('')
        })
    </script>

</body>

</html>
