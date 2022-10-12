@extends('layout.administration-layout')

@section('title', 'Pending Students | ' . env('APP_NAME'))


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
            <h2 class="page-title">Pending Students</h2>
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
                    @foreach ($registrations as $registration)
                        <tr>
                            <td>
                                <a href="/administration/teachers/{{ $registration->id }}">{{ $registration->lastname }}</a>
                            </td>
                            <td>
                                <a href="/administration/teachers/{{ $registration->id }}">{{ $registration->firstname }}</a>
                            </td>
                            <td>
                                <a href="/administration/teachers/{{ $registration->id }}">{{ $registration->lastname }}</a>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="action-update" value="{{ $registration->id }}">Accept</button>
                                    <button class="action-delete" value="{{ $registration->id }}">Reject</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>

    </div>

    <div id="confirm-accept-modal" class="modal" @unless($errors->any()) style="display: none" @endunless>
        <div class="modal-dialog">
            <header class="modal-header">
                <h3>Accept registration</h3>
            </header>
            <div class="modal-body">
                <form method="POST" action="/administration/students/accept" id="accept-registration-form">
                    @csrf
                    <p>Accept student's registration?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-close-button">Cancel</button>
                <button type="submit" form="accept-registration-form" name="registration_id">Accept</button>
            </div>
        </div>
    </div>

@endsection

@section('page_script')
    <script>
        $('.action-update').on('click', function() {
            $('#confirm-accept-modal button[type=submit]').val(this.value);
            $('#confirm-accept-modal').fadeIn();
        })

        $('.modal .modal-close-button').on('click', function() {
            $(this).parent().parent().parent().fadeOut()
        })
    </script>
@endsection
