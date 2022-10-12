@extends('layout.administration-layout')

@section('title', 'Teachers | ' . env('APP_NAME'))

@section('page_style')
    <style>
        /* add teacher form */
        #add-teacher-form {
            display: flex;
            flex-flow: column;
            gap: .75rem;
        }

        #add-teacher-form>div {
            display: flex;
            flex-flow: column;
            gap: .25rem;
        }

        #add-teacher-form>div>input {
            padding: .25rem;
            border: 1px solid var(--grey-color);
        }

        /* error message */
        .error_message {
            color: red;
            font-size: smaller;
        }
    </style>
@endsection

@section('page_content')

    <div id="main">

        <header id="page-header">
            <h2 class="page-title">Teachers</h2>
            <button id="add-teacher-button" href="/administration/teachers/add">Add</button>
        </header>

        <main id="page-content">
            <table>
                <thead>
                    <tr>
                        <th>Teacher ID</th>
                        <th>Surname</th>
                        <th>Given name</th>
                        <th>Middle name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td><a href="/administration/teachers/{{ $teacher->id }}">{{ $teacher->teacher_id }}</a></td>
                            <td><a href="/administration/teachers/{{ $teacher->id }}">{{ $teacher->lastname }}</a></td>
                            <td><a href="/administration/teachers/{{ $teacher->id }}">{{ $teacher->firstname }}</a></td>
                            <td><a href="/administration/teachers/{{ $teacher->id }}">{{ $teacher->lastname }}</a></td>
                            <td>
                                <div class="actions">
                                    <button class="action-update">Update</button>
                                    <button class="action-delete">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>

    </div>

    <div id="add-teacher-modal" class="modal" @unless($errors->any()) style="display: none" @endunless>
        <div class="modal-dialog">
            <header class="modal-header">
                <h3>Add teacher</h3>
            </header>
            <div class="modal-body">
                <form action="/administration/teachers/add" id="add-teacher-form" method="POST">
                    @csrf
                    <div>
                        <label for="teacher_id">Teacher ID</label>
                        <input type="text" name="teacher_id" id="teacher_id" pattern="[0-9]{7}" value="{{ old('teacher_id') }}" required>
                        @error('teacher_id')
                            <div class="error_message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
                        @error('lastname')
                            <div class="error_message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="firstname">First name</label>
                        <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
                        @error('firstname')
                            <div class="error_message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="middlename">Middle name</label>
                        <input type="text" name="middlename" id="middlename" value="{{ old('middlename') }}">
                    </div>
                    <div>
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email" pattern="(?![_.-])((?![_.-][_.-])[\w.-]){0,63}[a-zA-Z\d]@((?!-)((?!--)[a-zA-Z\d-]){0,63}[a-zA-Z\d]\.){1,2}([a-zA-Z]{2,14}\.)?[a-zA-Z]{2,14}" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error_message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="phone_number">Phone number</label>
                        <input type="phone_number" name="phone_number" id="phone_number" pattern="09[0-9]{9}" value="{{ old('phone_number') }}" required>
                        @error('phone_number')
                            <div class="error_message">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-close-button">Close</button>
                <button type="submit" form="add-teacher-form">Save</button>
            </div>
        </div>
    </div>

@endsection

@section('page_script')
    <script>
        $('#add-teacher-button').on('click', function(e) {
            e.preventDefault();
            $('#add-teacher-modal').fadeIn();
        })

        $('#add-teacher-modal .modal-close-button').on('click', function() {
            $('#add-teacher-modal').fadeOut()
        })
    </script>
@endsection
