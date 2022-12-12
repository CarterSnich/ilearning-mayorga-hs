@extends('layout.teacher-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/teacher-class.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher-view-activity.css') }}">
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
                <a href="#" class="activity-options">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="inherit" d="M12 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m0-6a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2Z" />
                    </svg>
                </a>
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
        <div id="submissiones-wrapper">
            <h2>Submissions</h2>

            <div id="submissions">
                @foreach ($submissions as $sub)
                    <a href="#" data-target="{{ "#{$sub->id}-{$sub->username}-{$sub->activity_id}" }}">
                        <h4>{{ $sub->file }}</h4>
                        <small>
                            <span>{{ $sub->lastname }}, {{ $sub->firstname }} {{ $m = $sub->middlename ? $m[0] . '.' : '' }}</span>
                            •
                            <span>{{ Carbon\Carbon::parse($sub->created_at)->format('F j, Y') }}</span>
                        </small>
                    </a>
                @endforeach
            </div>

        </div>
    </div>

    @foreach ($submissions as $sub)
        <x-file-modal :sub="$sub" />
    @endforeach
@endsection

@section('page_script')
    <script src="{{ asset('quilljs/quill.min.js') }}"></script>
    <script src="{{ asset('quilljs/QuillDeltaToHtmlConverter.bundle.js') }}"></script>
    <script>
        let delta = JSON.parse($('#instructions').attr('data-delta'))
        const converter = new QuillDeltaToHtmlConverter(delta.ops, {});
        $('#instructions').html(converter.convert())

        $('#submissions>a').on('click', function(e) {
            e.preventDefault()

            let dataTarget = $(this).attr('data-target');
            $(dataTarget).fadeIn(300)
        })

        $('.file-modal').on('click', function(e) {
            if (e.target !== this) return;
            $(this).fadeOut(300)
        })
    </script>
@endsection
