@extends('layouts.frontend')

@section('pageCss')
    <style>
        body {
            background-color: #f5f7fb;
        }

        .auth-navbar {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 12px 0;
        }

        .auth-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .auth-card .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .gradient-header {
            background: linear-gradient(90deg, #004f7e, #00c4ff);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
@endsection

@section('homeContent')
    <!-- Top Navbar -->
    <div class="navbar">
        <div class="navbar-left">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('build/assets/img/logo.png') }}" alt="AKTech logo" />
                </div>
            </div>
        </div>
        <div class="navbar-right">
            <a class="nav-link" href="{{ route('view.home') }}">Home</a>

            <a class="nav-link" href="{{ route('teacher.panel') }}">
                {{-- <span class="teacher-btn-icon">T</span> --}}
                Teacher Section
            </a>
            <a href="{{ route('teacher.test.assign') }}" class="nav-link">
                Assign Test
            </a>
            <a href="{{ route('home.logout') }}" class="nav-link">
                Logout
            </a>

            <span class="teacher-btn" style="cursor: auto !important;">
                {{ $teacher->full_name }}
            </span>

        </div>
    </div>

    <!-- Student Records  -->
    <div class="container-fluid mt-5 px-5">
        <h2 class="mb-4">Teacher Dashboard</h2>

        <div class="row mb-4">
            <div class="col-md-3">
                <span class="teacher-btn" style="cursor: auto !important;">
                    Teacher Code: {{ $teacher->teacher_code }}
                </span>

            </div>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success m-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if (session('error'))
            <div class="alert alert-danger m-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('teacher.save.evaluation') }}" method="POST">
            @csrf

            <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

            @foreach($attempt->answers as $answer)

                @php
                    $question = $answer->question;
                @endphp

                <div class="card my-3 p-3">

                    <strong>Q{{ $loop->iteration }}:
                        {{ $question->question }}
                    </strong>
                    @if($attempt->testTemplate->type === 'objective')

                        @foreach(['A', 'B', 'C', 'D'] as $option)

                            @php
                                $optionText = strtolower($option);
                            @endphp

                            <p>

                                <strong>{{ $option }}.</strong>
                                {{ $question->$optionText }}


                                {{-- Correct Answer --}}
                                @if($question->answer == $option)
                                    <span class="text-success font-weight-bold"> ✔ </span>
                                @endif

                                {{-- Student Wrong Selection --}}
                                @if($answer->answer == $option && !$answer->is_correct)
                                    <span class="text-danger font-weight-bold"> ❌ </span>
                                @endif


                            </p>

                        @endforeach

                        <div class="mt-2">
                            <strong>Auto Marks:</strong>
                            {{ $answer->marks_obtained }}
                        </div>

                    @elseif($attempt->testTemplate->type === 'subjective')
                        <p>
                            <strong>Student Answer:</strong>
                            {{ $answer->answer }}
                        </p>
                    @endif

                    <div class="form-group">
                        <label>Marks (Max {{ $question->marks }})</label>
                        <input type="number" name="marks[{{ $answer->id }}]" value="{{ $answer->marks_obtained }}"
                            max="{{ $question->marks }}" class="form-control">
                    </div>

                </div>

            @endforeach
            <div class="mb-3">
                <button type="submit" class="btn btn-success">
                    Save Evaluation
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
        });
    </script>

@endpush