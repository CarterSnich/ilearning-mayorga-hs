<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Email Confirmation - Mayorga National High School</title>

    {{-- app style --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- page style --}}
    <style>
        body {
            height: auto;
            min-height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.25rem;
        }

        /* main */
        #main {
            position: relative;
            display: flex;
            flex-flow: column;
            height: max-content;
            width: 386px;
            gap: 1.25rem;
            border: 1px solid var(--grey-color);
            padding: 1.25rem;
            width: 386px;
            border-radius: .25rem;
        }

        /* logo wrapper */
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

        .login-wrapper>h2 {
            text-align: center;
        }

        /* form */
        form {
            display: flex;
            flex-flow: column;
            gap: .75rem;
        }

        form>button[type=submit] {
            border-radius: .25rem;
            padding: .75rem;
            border: 1px solid var(--grey-color);
            transition: all ease-in-out .3s
        }

        form>button[type=submit]:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-border);
            color: white;
        }

        form>button[type=submit]:active {
            background-color: var(--primary-active);
        }


        /* input */
        .input-floating {
            position: relative;
        }

        .input-floating input,
        .input-floating select {
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

        .input-floating select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M12 16l-6-6h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - .5rem);
        }

        .input-floating input:focus,
        .input-floating select:focus {
            border-color: var(--primary-color);

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
        .input-floating input:not(:placeholder-shown)+label,
        .input-floating select:focus+label,
        .input-floating select:not(:placeholder-shown)+label {
            transform: translateY(-100%);
            font-size: small;
            top: 40%;
        }


        .bottom-links {
            width: max-content;
            text-decoration: none;
            transition: all ease-in-out .3s;
        }

        .bottom-links,
        .bottom-links:visited {
            color: rgb(0, 0, 238)
        }

        .bottom-links:hover {
            color: var(--primary-color);
        }

        .bottom-links:active {
            color: var(--primary-active);
        }

        /* error message */
        .error-message {
            border: 1px solid var(--danger-border);
            padding: 0.75rem;
            border-radius: 0.25rem;
            color: var(--danger-color);
            text-align: center;
        }


        /* progress overlay */
        .progress-overlay {
            position: absolute;
            border-radius: inherit;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: 1;
            background-color: #00000080;
            display: flex;
        }

        .progress-overlay::after {
            content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='64' height='64'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z' fill='rgba(255,255,255,1)'/%3E%3C/svg%3E");
            height: 64px;
            width: 64px;
            margin: auto;
            animation: spin 1s linear infinite;

        }

        @keyframes spin {
            100% {
                rotate: 360deg;
            }
        }
    </style>

</head>

<body>

    <div id="main">
        {{-- logo wrapper --}}
        <div class="logo-wrapper">
            <img src="{{ asset('img/logo.png') }}" alt="">
            <div>
                <h2>iLearning</h2>
                <h4>Mayorga National High School</h4>
            </div>
        </div>

        {{-- email signup wrapper --}}
        <div class="login-wrapper">
            <h2>Email Confirmation</h2>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->all()[0] }}
                </div>
            @endif

            {{-- teacher login form --}}
            <form data-form-for="teacher" method="POST">
                @csrf

                {{-- email --}}
                <div class="input-floating">
                    <input type="email" name="email" id="email" placeholder=" ">
                    <label for="email">Email</label>
                </div>

                <button type="submit">CONFIRM</button>

                <a href="/student/signup" class="bottom-links">Already have a token?</a>

            </form>

        </div>

        {{-- progress overlay --}}
        <div class="progress-overlay" style="display: none;"></div>

    </div>



    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $('.login-buttons button').on('click', function() {
            let formTarget = $(this).addClass('active').siblings().removeClass('active').attr('data-form-target')
            $(`form[data-form-for=${formTarget}]`).hide().siblings().fadeIn()
            $('form :input').val('')
        })
    </script>

</body>

</html>
