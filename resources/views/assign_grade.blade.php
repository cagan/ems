@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Assign Grade To Student') }}</div>

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
                        <form method="POST" action="{{ route('store_assign_grade', ['id' => $examId]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Student</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="student_id">
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-md-4 col-form-label text-md-right">Grade</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="grade" value="{{ old('grade') }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection
