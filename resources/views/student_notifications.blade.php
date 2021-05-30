@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="list-group">
            @foreach($notificationMessages as $message)
                <li class="list-group-item disabled" aria-disabled="true">{{ $message['message'] }}</li>
            @endforeach
        </ul>
    </div>
@endsection
