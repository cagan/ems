@extends('layouts.app')

@section('content')
    <div class="card">
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
                <th scope="col">Lesson Code</th>
                <th scope="col">Department</th>
                <th scope="col">Lecturer</th>
                <th scope="col">Semester</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $index => $lesson)
                <tr>
                    <th schope="row">{{ $index + 1 }}</th>
                    <td>{{ $lesson->name }}</td>
                    <td>{{ $lesson->lesson_code }}</td>
                    <td>{{ $lesson->department->name }}</td>
                    @if(empty($lesson->lecturer?->name))
                        <td><a class="btn btn-sm btn-success" href="{{route("show_assign_lecturer", ['id' => $lesson->id])}}">Assign Lecturer</a></td>
                    @else
                        <td>{{ $lesson->lecturer?->name }} {{ $lesson->lecturer?->surname }}</td>
                    @endif
                    <td>{{ $lesson->semester->year }} {{ $lesson->semester->type }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
