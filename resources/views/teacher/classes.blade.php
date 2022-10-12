@extends('layout.teacher-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/teacher-classes.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="card-group">
        {{-- @dd($classes) --}}

        @foreach ($classes as $class)
            <div class="card">
                <div class="card-header sp-{{ $class->class_color }}">
                    <a href="/teacher/classes/{{ $class->id }}">
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

    {{-- create class modal --}}
    <div class="modal create-class-modal" @unless($errors->any())  style="display: none" @endunless>
        <div class="modal-dialog">
            <form action="/teacher/classes/add" method="POST">
                @csrf

                <h2>Create class</h2>

                <div class="input-group">
                    <label for="name">Section name</label>
                    <input type="text" class="input" id="name" value="{{ old('name') }}" name="name">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="name">Subject</label>
                    <input type="text" class="input" id="subject" value="{{ old('subject') }}" name="subject">
                    @error('subject')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="description">Description</label>
                    <input type="text" class="input" id="description" value="{{ old('description') }}" name="description">
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Color</label>
                    <div class="color-selections">
                        @foreach (App\Models\Mclass::$colors as $color)
                            <label for="sp-{{ $color }}" class="color-item">
                                <div class="sp-preview sp-{{ $color }}"></div>
                                <input type="radio" name="class_color" value="{{ $color }}" id="sp-{{ $color }}">
                            </label>
                        @endforeach
                    </div>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-buttons">
                    <button type="submit" class="button">Create</button>
                    <button type="button" class="button cancel">Cancel</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        $('.add-class-button').on('click', function() {
            $('.create-class-modal').fadeIn(300)
        })

        $('.modal .form-buttons>.cancel').on('click', function() {
            $(this).parent().parent().parent().parent().fadeOut(300)
        })
    </script>
@endsection
