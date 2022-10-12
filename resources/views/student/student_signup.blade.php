<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iLearning - Mayorga National High School</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

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
            display: flex;
            flex-flow: column;
            height: max-content;
            gap: 1.25rem;
            border: 1px solid var(--grey-color);
            padding: 1.25rem;
            width: 768px;
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


        /* login information and name */
        form>div.ab {
            display: flex;
            gap: .75rem;
        }

        form>div.ab>div {
            display: flex;
            flex-flow: column;
            gap: .25rem;
            flex-grow: 1
        }

        /* section and year level */
        form>div.c {
            display: flex;
            flex-flow: column;
            gap: .25rem;
        }

        form>div.c>div {
            display: flex;
            gap: .75rem;
        }


        form>div.c>div>div {
            flex: 1 1 0;
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

        /* input checkbox */
        .input-checkbox {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0.5rem;
        }


        .error-message {
            border: 1px solid var(--danger-border);
            padding: 0.75rem;
            border-radius: 0.25rem;
            color: var(--danger-color);
            text-align: center;
        }

        .bottom-links-row {
            display: flex;
            flex-direction: row;
            gap: .25rem;
            justify-content: space-between
        }

        .bottom-links-column {
            display: flex;
            flex-direction: column;
            gap: .25rem;
            align-items: center
        }

        .confirmation-options {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1.25rem;
        }

        .confirmation-options>button {
            border-radius: .25rem;
            transition: all ease-in-out .3s
        }

        .confirmation-options>button:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-border);
            color: white;
        }

        .confirmation-options>button:active {
            background-color: var(--primary-active);
        }

        .confirmation-options>a {
            text-decoration: none;
        }

        .confirmation-options>a:hover {
            color: var(--primary-color);
        }

        .confirmation-options>a:active {
            color: var(--primary-active);
        }

        .confirmation-options>a:disabled {
            cursor: default;
            pointer-events: none;

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

        {{-- login wrapper --}}
        <div class="login-wrapper">
            <h2>Student Sign Up</h2>


            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->all()[0] }}
                </div>
            @endif

            {{-- teacher login form --}}
            <form data-form-for="teacher" action="/student/signup" method="POST">
                @csrf
                <div class="ab">
                    {{-- login details --}}
                    <div class="a">
                        <h4>Login information</h4>

                        {{-- username --}}
                        <div class="input-floating">
                            <input type="text" name="username" id="username" placeholder=" " value="{{ old('username') }}" required>
                            <label for="username">Username</label>
                        </div>

                        {{-- password --}}
                        <div class="input-floating">
                            <input type="password" name="password" id="password" placeholder=" " required>
                            <label for="password">Password</label>
                        </div>

                        {{-- confirm password --}}
                        <div class="input-floating @error('password_confirmation')  @enderror">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                            <label for="password_confirmation">Re-type password</label>
                        </div>
                    </div>

                    {{-- name --}}
                    <div class="b">
                        <h4>Name</h4>

                        {{-- lastname --}}
                        <div class="input-floating">
                            <input type="text" name="lastname" id="lastname" placeholder=" " value="{{ old('lastname') }}" required>
                            <label for="lastname">Last name</label>
                        </div>

                        {{-- firstname --}}
                        <div class="input-floating">
                            <input type="text" name="firstname" id="firstname" placeholder=" " value="{{ old('firstname') }}" required>
                            <label for="firstname">First name</label>
                        </div>

                        {{-- lastname --}}
                        <div class="input-floating">
                            <input type="text" name="middlename" id="middlename" placeholder=" " value="{{ old('middlename') }}">
                            <label for="middlename">Middle name</label>
                        </div>

                    </div>

                </div>

                {{-- Section and Year level --}}
                <div class="c">
                    <h4>Section and Year level</h4>

                    <div>
                        {{-- Section --}}
                        <div class="input-floating">
                            <input type="text" name="section" id="section" placeholder=" " value="{{ old('section') }}" required>
                            <label for="section">Section</label>
                        </div>

                        {{-- lastname --}}
                        <div class="input-floating">
                            <select name="year_level" id="year_level" required>
                                <option value="" disabled selected>Select year level</option>
                                @for ($yr = 7; $yr <= 12; $yr++)
                                    <option value="{{ $yr }}" @if (old('year_level') == $yr) selected @endif>
                                        Grade {{ $yr }} {{ $yr <= 10 ? 'Junior' : 'Senior' }} High School
                                    </option>
                                @endfor
                            </select>
                            <label for="year_level">Year level</label>
                        </div>
                    </div>
                </div>


                {{-- contact information --}}
                <div class="c">
                    <h4>Contact information</h4>

                    <div>
                        {{-- email --}}
                        <div class="input-floating">
                            <input type="email" name="email" id="email" placeholder=" " pattern="(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>

                        {{-- lastname --}}
                        <div class="input-floating">
                            <input type="text" name="phone_number" id="phone_number" placeholder=" " pattern="09[0-9]{9}" value="{{ old('phone_number') }}" required>
                            <label for="phone_number">Phone number</label>
                        </div>
                    </div>
                </div>


                {{-- sign up token --}}
                <div class="c">
                    <h4>Sign-up token</h4>

                    <div class="input-floating">
                        <input type="text" name="signup_token" id="signup_token" placeholder=" ">
                        <label for="signup_token">Token</label>
                    </div>
                </div>

                {{-- aggreement checkbox --}}
                <div class="input-checkbox">
                    <input type="checkbox" name="aggreement" id="aggreement" required>
                    <label for="aggreement">I have read and accepted the <a href="/terms-and-privacy" target="_blank">Terms of Use</a> and <a href="/terms-and-privacy" target="_blank">Privacy Policy</a>.</label>
                </div>

                <button type="submit">SIGN UP</button>

            </form>

            <div class="bottom-links-row">
                <a href="/?t=student">Go back to Sign In</a>
                <a href="/student/email-signup">Email sign-up</a>
            </div>

        </div>

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
