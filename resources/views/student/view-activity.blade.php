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
        <form class="submission">

            <h2>Your work</h2>

            <div class="work-input-wrapper">
                <button type="button">Add work</button>
                <button type="button" disabled>Submit</button>
            </div>

            <input type="file" name="work" id="work" style="display: none">

        </form>



    </div>
@endsection

@section('page_script')
    <script src="{{ asset('quilljs/quill.min.js') }}"></script>
    <script src="{{ asset('quilljs/QuillDeltaToHtmlConverter.bundle.js') }}"></script>
    <script>
        let delta = JSON.parse($('#instructions').attr('data-delta'))
        const converter = new QuillDeltaToHtmlConverter(delta.ops, {});
        $('#instructions').html(converter.convert())
    </script>
@endsection
