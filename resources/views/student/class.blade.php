@extends('layout.student-layout')


{{-- page style --}}
@section('page_style')
    <link rel="stylesheet" href="{{ asset('css/student-class.css') }}">
@endsection

{{-- page content --}}
@section('page_content')
    <div class="class-hero banner-{{ $class->class_color }}">
        <h2>{{ $class->subject }}</h2>
        <p>{{ $class->name }}</p>
    </div>
@endsection

@section('page_script')
    <script></script>
@endsection
