@extends('layout.teacher-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/teacher-class.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher-class-class.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="class-hero banner-{{ $mclass->class_color }}">
        <h2>{{ $mclass->subject }}</h2>
        <p>{{ $mclass->name }}</p>


        <div class="backdrop"></div>
    </div>

    <div class="class-content">

        <div class="left">

            <div class="class-code">
                <div>
                    <small>Class code</small>
                </div>
                <div class="code">
                    <code id="class-code">{{ $mclass->code }}</code>
                    <button class="class-code-copy"></button>
                </div>
            </div>

        </div>

        <div class="right">

            <a href="/teacher/classes/{{ $mclass->id }}/activity/create" type="button" id="add-activity">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </a>

            @foreach ($classActivities as $activity)
                <a href="{{ request()->url() . "/activity/{$activity->id}" }}" class="class-activity">
                    <span>
                        <svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class="bi">
                            <path fill="white" d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H6V4h2v8l2.5-1.5L13 12V4h5v16z"></path>
                        </svg>
                    </span>
                    <span>
                        <div class="class-activity-title">{{ $activity->title }}</div>
                        <small class="class-activity-date">{{ Carbon\Carbon::parse($activity->created_at)->format('F j, Y') }}</small>
                    </span>
                </a>
            @endforeach

        </div>


    </div>
@endsection

@section('page_script')
    <script>
        $('.class-code-copy').on('click', function() {
            // Get the text field
            var copyText = document.getElementById('class-code');

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
        })
    </script>
@endsection
