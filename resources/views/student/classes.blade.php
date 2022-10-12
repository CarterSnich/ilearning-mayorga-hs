@extends('layout.student-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/student-classes.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="card-group">
        @foreach ($classes as $class)
            <div class="card">
                <div class="card-header sp-{{ $class->class_color }}">
                    <a href="/student/classes/{{ $class->id }}">
                        <h4>{{ $class->name }}</h4>
                        <p>{{ $class->subject }}</p>
                    </a>
                </div>
                <div class="card-body">
                    <a href="#">{{ $class->description }}</a>
                </div>
            </div>
        @endforeach

    </div>

    {{-- join class modal --}}
    <div class="modal join-class-modal" @unless($errors->any())  style="display: none" @endunless>
        <div class="modal-dialog">
            <form action="/student/classes/join" method="POST">
                @csrf

                <h2>Join class</h2>

                <div class="input-group">
                    <label for="name">Class code</label>
                    <input type="text" class="input" id="code" name="code">
                </div>

                <div class="form-buttons">
                    <button type="submit" class="button">Join</button>
                    <button type="button" class="button cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        $('.add-class-button').on('click', function() {
            $('.join-class-modal').fadeIn(300)
        })

        $('.modal .form-buttons>.cancel').on('click', function() {
            $(this).parent().parent().parent().parent().fadeOut(300)
        })
    </script>
@endsection
