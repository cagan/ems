@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Quota</th>
                <th scope="col">Lesson Code</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $index => $lesson)
                <tr>
                    <th schope="row">{{ $index + 1 }}</th>
                    <td>{{ $lesson->name }}</td>
                    <td>{{ $lesson->quota }}</td>
                    <td>{{ $lesson->lesson_code }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
