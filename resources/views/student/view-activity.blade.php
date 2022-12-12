@extends('layout.student-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/teacher-class.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher-view-activity.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student-view-activity.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="class-hero banner-{{ $mclass->class_color }}">
        <h2>{{ $mclass->subject }}</h2>
        <p>{{ $mclass->name }}</p>
        <div class="backdrop"></div>
    </div>

    <div class="class-content">

        {{-- header --}}
        <div class="activity-header">
            <div>
                <h3>{{ $classActivity->title }}</h3>
            </div>
            <div>
                <small>{{ $classActivity->score }} points</small>
                <small>
                    Deadline: {{ Carbon\Carbon::parse($classActivity->deadline)->format('F d, Y') }}
                    •
                    {{ $classActivity->status ? 'Open' : 'Closed' }}
                </small>
            </div>
        </div>

        {{-- instructions --}}
        <div id="instructions" data-delta="{{ $classActivity->instructions }}"></div>

        {{-- module --}}
        @if ($classActivity->module)
            <x-module :file="$classActivity->module" />
        @endif

        {{-- submissions --}}
        @if ($submission)
            <form action="{{ request()->url() . '/unsubmit' }}" method="POST">
                @csrf
                <h2>Your work</h2>
                <div class="work-input-wrapper">
                    <div id="submitted-file">
                        <a href="{{ asset('storage/app/submissions/' . auth()->user()->username . '/' . $submission->activity_id . '/' . $submission->file) }}" target="_blank">
                            {{ $submission->file }}
                        </a>
                        <span><b>{{ $submission->score }}</b> / {{ $classActivity->score }}</span>
                    </div>
                    @unless($submission->score)
                        <button class="submit" id="unsubmit-button">Unsubmit</button>
                    @endunless
                </div>
            </form>
        @else
            <form class="submission" action="{{ request()->url() . '/submit' }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h2>Your work</h2>
                <div class="work-input-wrapper">
                    <button type="button" id="add-work-button">Add work</button>
                    <div id="uploaded-file"></div>
                    <button type="submit" id="submit-work-button" disabled>Submit</button>
                </div>
                <input type="file" name="file" id="work" class="hidden">
            </form>
        @endif


    </div>
@endsection

@section('page_script')
    <script src="{{ asset('quilljs/quill.min.js') }}"></script>
    <script src="{{ asset('quilljs/QuillDeltaToHtmlConverter.bundle.js') }}"></script>
    <script>
        let delta = JSON.parse($('#instructions').attr('data-delta'))
        const converter = new QuillDeltaToHtmlConverter(delta.ops, {});
        $('#instructions').html(converter.convert())

        $('#add-work-button').on('click', function() {
            $('#work').click();
        })

        $('#work').on('change', function() {
            $('#uploaded-file').html(`
                <div>
                    <span>${this.files[0].name}</span>
                    <button type="button" id="remove-work-button">
                        <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                            <rect x="0" y="0" width="16" height="16" fill="none" stroke="none" />
                            <path fill="currentColor" fill-rule="evenodd" d="M3.72 3.72a.75.75 0 0 1 1.06 0L8 6.94l3.22-3.22a.75.75 0 1 1 1.06 1.06L9.06 8l3.22 3.22a.75.75 0 1 1-1.06 1.06L8 9.06l-3.22 3.22a.75.75 0 0 1-1.06-1.06L6.94 8L3.72 4.78a.75.75 0 0 1 0-1.06z" />
                        </svg>
                    </button>
                </div>
            `)

            $('#add-work-button').addClass('hidden')
            $('#submit-work-button').attr('disabled', false)
        })

        $('#uploaded-file').on('click', '#remove-work-button', function() {
            $('#uploaded-file').html('')
            $('#add-work-button').removeClass('hidden')
            $('#submit-work-button').attr('disabled', true)
        })
    </script>
@endsection
