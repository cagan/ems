@extends('layouts.app')

@section('content')
    <h1>Update Exam:</h1>

    <a href="{{ route('show_assign_grade', ['id' => $exam->id]) }}" class="btn btn-success" style="margin-top: 10px; display: inline-block">Assign Grade</a>
    <br><br>

    @if($errors->any())
        <div class="alert alert-danger">
            <p><strong>Something went wrong</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('exam_create_success'))
        <div class="alert alert-success">
            {!! session('exam_create_success') !!}
        </div>
    @endif

    <form method="POST" action="{{ route('exam.update.save', ['id' => $exam->id]) }}">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Lesson:</label>
            <input class="form-control" type="text" disabled name="lesson" value="{{ $exam->lesson->name }}">
        </div>
        <div class="form-group">
            <label for="example-datetime-local-input">Date and time</label>
            <input class="form-control" type="datetime" id="example-datetime-local-input" name="datetime" value="{{ $exam->exam_date }}">
        </div>
        <div class="form-group">
            <label for="example-datetime-local-input">Duration</label>
            <input class="form-control" type="number" id="duration" name="duration" placeholder="40" value="{{ $exam->duration ?? old('duration') }}">
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Additional Notes:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="notes">{{ $exam->notes ?? old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>



@endsection
