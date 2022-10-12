<style>
    nav#administration-nav {
        /* layout */
        position: relative;
        width: fit-content;
        height: 100%;

        /* self */
        background-color: #1f272d;
    }


    nav#administration-nav * {
        color: white;
    }

    /* sidebar toggle */
    nav#administration-nav>.sidebar-toggle {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: none;
        height: 80px;
        width: 1rem;
        background-color: white;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        clip-path: polygon(0% 0%,
                100% 20%,
                100% 80%,
                0% 100%);
    }

    nav#administration-nav>.sidebar-toggle>i {
        width: .5rem;
        color: rgb(31, 39, 45);
    }

    nav#administration-nav.collapsed>.nav-content {
        width: 0px;
    }

    nav#administration-nav.collapsed>.sidebar-toggle>i {
        transform: rotateY(180deg)
    }

    /* nav content */
    .nav-content {
        position: relative;
        display: flex;
        flex-flow: column;
        gap: 1.25rem;
        width: 278px;
        overflow-x: hidden;
        height: 100%;
        transition: width ease-in-out 0.3s;
    }

    .nav-content>* {
        min-width: 278px;
    }

    /* brand */
    a#brand-link {
        margin: 1.25rem;
        display: flex;
        text-decoration: none;
        gap: 1.25rem;
        align-items: center
    }

    a#brand-link>img {
        height: 52px;
    }

    /* nav links */
    .nav-links {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-links>li {
        box-sizing: content-box;
    }

    .nav-links>li>a {
        position: relative;
        display: flex;
        gap: 1.25rem;
        align-items: center;
        text-decoration: none;
        padding: 1rem 2.25rem;
        font-size: large;
        transition: all ease-in-out .3s;
    }

    .nav-links>li>a:hover:not([aria-current=page]),
    .nav-links>li>a.collapsible.collapsed {
        color: black !important;
        background-color: #FEFEA4;
    }

    .nav-links>li>a.collapsible::after {
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z' fill='rgba(255,255,255,1)'/%3E%3C/svg%3E");
        position: absolute;
        right: .75rem;
        height: 24px;
        width: 24px;
        color: white;
        rotate: x 180deg;
        transition: all ease-in-out .3s;
    }

    .nav-links>li>a.collapsible.collapsed::after,
    .nav-links>li>a:hover.collapsible:after {
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3Cpath d='M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z' fill='rgba(0,0,0,1)'/%3E%3C/svg%3E");
    }

    .nav-links>li>a.collapsible.collapsed::after {
        rotate: x 0deg;
    }


    .nav-links>li>a[aria-current=page] {
        background-color: #151B1F;
    }

    /* collapsible */
    .collapsible-links {
        font-size: medium;
        list-style: none;
        margin: 0;
        padding: 0;
        height: auto;
        max-height: 500px;
        overflow: hidden;
        transition: max-height ease-in-out .3s
    }

    .collapsible-links.collapsed {
        max-height: 0;
    }

    .collapsible-links * {
        min-height: max-content;
    }

    .collapsible-links>li {
        box-sizing: content-box;
    }

    .collapsible-links>li>a {
        display: block;
        padding: .75rem;
        padding-left: 6.25rem;
        text-decoration: none;
        transition: all ease-in-out .3s;
    }

    .collapsible-links>li>a:hover {
        background-color: #FEFEA4;
        color: black !important;
    }

    .collapsible-links>li>a[aria-current=page] {
        font-weight: bolder
    }

    /* logout-form */
    .logout-form {
        margin-top: auto;
        border: 1px solid red
    }
</style>

<nav id="administration-nav">

    <button class="sidebar-toggle">
        <i class="fa-solid fa-chevron-left"></i>
    </button>

    <div class="nav-content">

        <a href="/administration/dashboard" id="brand-link">
            <img src="{{ asset('img/logo.png') }}" alt="">
            <div>
                iLearning
                <br>
                Mayorga National HS
            </div>
        </a>

        <ul class="nav-links">
            <li>
                <a @if (request()->is('administration/dashboard')) href="#main" aria-current="page" @else href="/administration/dashboard" @endif>
                    <img src="{{ asset('img/icons8-home-page-32.png') }}" alt="">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#main" class="collapsible @if (request()->is('administration/students')) collapsed @endif" data-collapsible-target="#student-status-links">
                    <img src="{{ asset('img/icons8-students-32.png') }}" alt="">
                    Students
                </a>
                <ul id="student-status-links" class="collapsible-links @unless(request()->is('administration/students')) collapsed @endunless">
                    <li>
                        <a href="/administration/students?s=pending" @if (request()->get('s') == 'pending') aria-current="page" @endif>Pending</a>
                    </li>
                    <li>
                        <a href="/administration/students?s=enrolled" @if (request()->get('s') == 'enrolled') aria-current="page" @endif>Enrolled</a>
                    </li>
                    <li>
                        <a href="/administration/students?s=enrolled" @if (request()->get('s') == 'rejected') aria-current="page" @endif>Rejected</a>
                    </li>
                </ul>
            </li>
            <li>
                <a @if (request()->is('administration/teachers')) href="#main" aria-current="page" @else href="/administration/teachers" @endif>
                    <img src="{{ asset('img/icons8-team-32.png') }}" alt="">
                    Teachers
                </a>
            </li>
            <li>
                <a @if (request()->is('administration/classes')) href="#main" aria-current="page" @else href="/administration/classes" @endif>
                    <img src="{{ asset('img/icons8-class-32.png') }}" alt="">
                    Classes
                </a>
            </li>
        </ul>

        <form action="/administration/logout" method="POST" class="logout-form">
            @csrf
            <p>{{ auth('administrator')->user()->name }}</p>
            <button type="submit">logout</button>
        </form>

    </div>

</nav>

@section('nav_script')
    <script>
        $('nav#administration-nav>.sidebar-toggle').on('click', function() {
            $('nav#administration-nav').toggleClass('collapsed')
        })

        $('ul.nav-links>li>a.collapsible').on('click', function() {
            $('ul.nav-links>li>a.collapsible').toggleClass('collapsed')
            $($('ul.nav-links>li>a.collapsible').attr('data-collapsible-target')).toggleClass('collapsed')
        })
    </script>
@endsection
