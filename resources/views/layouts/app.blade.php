<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Exam Management System') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"
        integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA=="
        crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"
          integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg=="
          crossorigin="anonymous"/>
</head>
<body class="bg-dark">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark 2xl:bg-black shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ 'Exam Management System' }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @can('access-admin')
                        @if (Route::has('create_lesson'))
                            <li class="nav-item text-white-50">
                                <a class="nav-link text-warning" href="{{ route('create_lesson') }}">{{ __('Create Lesson') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register_student'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('register_student') }}">{{ __('New Student') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register_lecturer'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('register_lecturer') }}">{{ __('New Lecturer') }}</a>
                            </li>
                        @endif
                        @if (Route::has('show_assignments'))
                            <li class="nav-item">
                                <a class="nav-link text-warning"
                                   href="{{ route('show_assignments') }}">{{ __('Show Assignments') }}</a>
                            </li>
                        @endif
                    @endcan

                    @can('access-lecturer')
                        @if(Route::has('exam.create'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('exam.create') }}">{{ __('Create Exam') }}</a>
                            </li>
                        @endif
                        @if(Route::has('exam.my_exams'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('exam.my_exams') }}">{{ __('My Exams') }}</a>
                            </li>
                        @endif
                        @if(Route::has('lecturer_my_lessons'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('lecturer_my_lessons') }}">{{ __('My Lessons') }}</a>
                            </li>
                        @endif
                        {{--                                @if(Route::has('assign_grade'))--}}
                        {{--                                    <li class="nav-item">--}}
                        {{--                                        <a class="nav-link" href="{{ route('assign_grade') }}">{{ __('Assign Grade') }}</a>--}}
                        {{--                                    </li>--}}
                        {{--                                @endif--}}
                    @endcan
                    @can('access-student')
                        @if(Route::has('student_register_lesson'))
                            <li class="nav-item">
                                <a class="nav-link text-warning"
                                   href="{{ route('student_register_lesson') }}">{{ __('Register Lesson') }}</a>
                            </li>
                        @endif
                        @if(Route::has('student_my_exams'))
                            <li class="nav-item">
                                <a class="nav-link text-warning"
                                   href="{{ route('student_my_exams') }}">{{ __('My Exams') }}</a>
                            </li>
                        @endif
                            @if(Route::has('student_show_notifications'))
                                <li class="nav-item">
                                    <a class="nav-link text-warning"
                                       href="{{ route('student_show_notifications') }}">{{ __('Notifications') }}</a>
                                </li>
                            @endif
                    @endcan

                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
