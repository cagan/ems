@extends('layouts.app')

@section('content')
    <h1>New Exam:</h1>

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

    <form method="post" action="{{ route('exam.create') }}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Lesson</label>
            <select class="form-control form-control-lg" name="lesson_id">
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id}}">{{ $lesson->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="example-datetime-local-input">Date and time</label>
                <input class="form-control" type="datetime-local" id="example-datetime-local-input" name="datetime" value="{{ old('datetime') }}">
        </div>
        <div class="form-group">
            <label for="example-datetime-local-input">Duration</label>
            <input class="form-control" type="number" id="duration" name="duration" placeholder="40" value="{{ old('duration') }}">
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Additional Notes:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="notes">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
