@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="col-md-6 offset-md-4">Lesson: {{ $lesson->name }}</h3>
        <form method="POST" action="{{ route('assign_lecturer', ['id' => $lesson->id]) }}">
            @csrf
            <div class="form-group row">
                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Lecturer</label>
                <div class="col-md-6">
                    <select class="form-control" name="lecturer_id">
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}">{{ $lecturer->name }} {{ $lecturer->surname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Assign') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
