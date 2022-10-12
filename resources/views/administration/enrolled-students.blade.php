@extends('layout.administration-layout')

@section('title', 'Teachers | ' . env('APP_NAME'))


@section('page_style')
    <style>

    </style>
@endsection

@section('page_content')

    <div id="main">

        <header id="page-header">
            <h2 class="page-title">Enrolled Students</h2>
            {{-- <a id="add-teacher-button" href="/administration/teachers/add">Add</a> --}}
        </header>

        <main id="page-content">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>First name</th>
                        <th>Middle name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>
                                <a href="/administration/teachers/{{ $student->id }}">{{ $student->lastname }}</a>
                            </td>
                            <td>
                                <a href="/administration/teachers/{{ $student->id }}">{{ $student->firstname }}</a>
                            </td>
                            <td>
                                <a href="/administration/teachers/{{ $student->id }}">{{ $student->lastname }}</a>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="action-view" data-id="{{ $student->id }}">View</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>

    </div>

    <div id="add-teacher-modal" style="display: none">
        <div class="modal-dialog">
            <header class="modal-header">
                <h3>Add teacher</h3>
            </header>
            <div class="modal-body">
                <form action="/administration/teachers/add" id="add-teacher-form" method="POST">
                    @csrf
                    <div>
                        <label for="teacher_id">Teacher ID</label>
                        <input type="text" name="teacher_id" id="teacher_id" pattern="[0-9]{7}" required>
                    </div>
                    <div>
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" required>
                    </div>
                    <div>
                        <label for="firstname">First name</label>
                        <input type="text" name="firstname" id="firstname" required>
                    </div>
                    <div>
                        <label for="middlename">Middle name</label>
                        <input type="text" name="middlename" id="middlename">
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
    <script></script>
@endsection
