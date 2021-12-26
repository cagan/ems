@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-info">
                {!! session('message') !!}
            </div>
        @endif
            <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Lesson</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Is On Schedule</th>
                    <th scope="col">Date</th>
                    <th scope="col">Results</th>
                </tr>
            </thead>
            <tbody>
            @foreach($exams as $index => $exam)
                <tr>
                    <th schope="row">{{ $index + 1 }}</th>
                    <td>{{ $exam->name }}</td>
                    <td>{{ $exam->duration }}</td>
                    <td>{{ $exam->is_date_passed ? 'NO' : 'YES' }}</td>
                    <td>{{ $exam->exam_date }}</td>
                    <td>{{ $exam?->point ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
            </div>
    </div>
@endsection
