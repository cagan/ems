@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create New Lesson') }}</div>

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

                    <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo session('success'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store_lesson') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Lesson Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="department_id">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Semester</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="semester_id">
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}">{{ $semester->year }} - {{ $semester->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
