@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
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

        <h3 class="col-md-6 offset-md-4">Lessons: </h3>
        <form method="POST" action="{{ route('student_register_lesson_store') }}">
            @csrf
            <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Lessons</label>
                <div class="col-md-6">
                    <select class="form-control" name="lesson_id">
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register Lesson') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
