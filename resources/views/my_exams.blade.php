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
                    <th scope="col">Lesson</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Is On Schedule</th>
                    <th scope="col">Date</th>
                    <th scope="col">Update</th>
                </tr>
                </thead>
                <tbody>
                @foreach($exams as $index => $exam)
                    <tr>
                        <th schope="row">{{ $index + 1 }}</th>
                        <td>{{ $exam->lesson->name }}</td>
                        <td>{{ $exam->duration }}</td>
                        <td>{{ $exam->is_date_passed ? 'NO' : 'YES' }}</td>
                        <td>{{ $exam->exam_date }}</td>
                        <th scope="col"><a href="{{ route('exam.update', ['id' => $exam->id]) }}" class="btn btn-success btn-sm">Update</a></th>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection
