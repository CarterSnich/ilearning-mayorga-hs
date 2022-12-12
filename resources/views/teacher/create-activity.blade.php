@extends('layout.teacher-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/teacher-class.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher-create-activity.css') }}">
    <link rel="stylesheet" href="{{ asset('quilljs/quill.snow.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="class-hero banner-{{ $mclass->class_color }}">
        <h2>{{ $mclass->subject }}</h2>
        <p>{{ $mclass->name }}</p>
        <div class="backdrop"></div>
    </div>

    <div class="class-content">

        <h2>Create activity</h2>

        <form action="{{ request()->url() }}/submit" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- activity title --}}
            <div class="row">
                <div class="input-group">
                    <label for="title" class="input-label">Activity title <span class="required-indicator">*</span></label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>
            </div>

            {{-- quill editor --}}
            <div class="row">
                <div class="input-group">
                    <label for="quill" class="input-label">Instructions/Directions</label>
                    <div id="quill-wrapper">
                        <div id="quill-editor"></div>
                    </div>
                    <input type="hidden" name="instructions">
                </div>
            </div>

            {{-- module --}}
            <div class="third-row">
                <div class="input-group">
                    <label for="module" class="input-label">Module</label>
                    <input type="file" name="module" id="module">
                </div>

                <div class="input-group">
                    <label for="score" class="input-label">Max score <span class="required-indicator">*</span></label>
                    <input type="number" class="form-control" name="score" id="score">
                </div>
            </div>

            <div class="fourth-row">

                {{-- deadline --}}
                <div class="input-group">
                    <label for="deadline" class="input-label">
                        Deadline <span class="required-indicator">*</span>
                    </label>
                    <input type="date" name="deadline" id="deadline" required>
                </div>

                {{-- status --}}
                <div class="input-group" id="status-field">
                    <label for="status" class="input-label">Status <span class="required-indicator">*</span></label>
                    <div class="radios">
                        <div>
                            <input type="radio" name="status" id="status-open" value="1" checked required>
                            <label for="status-open">Open</label>
                        </div>
                        <div>
                            <input type="radio" name="status" id="status-closed" value="0">
                            <label for="status-closed">Closed</label>
                        </div>
                    </div>
                </div>


            </div>

            {{-- submit --}}
            <div class="last-row">
                <button type="submit">Submit</button>
            </div>

        </form>

    </div>
@endsection

@section('page_script')
    <script src="{{ asset('quilljs/quill.min.js') }}"></script>
    <script>
        var toolbarOptions = [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            ['clean']
        ];

        let quill = new Quill('#quill-editor', {
            debug: 'info',
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: 'Type something here...',
            theme: 'snow',
            debug: false
        })

        quill.on('text-change', function(delta, oldDelta, source) {
            let stringedDelta = JSON.stringify(quill.getContents())
            $('input[name=instructions]').val(stringedDelta)
            console.log(stringedDelta)
        });


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
