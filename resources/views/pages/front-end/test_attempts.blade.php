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

        <div class="card my-5">
            <div class="card-header gradient-header text-white">
                <h5 class="mb-0">Student Result</h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Total Marks</th>
                            <th>Obtained</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($attempts as $attempt)

                            <tr>
                                <td>{{ $attempt->student->full_name }}</td>
                                <td>{{ $attempt->student->user->email }}</td>
                                <td>{{ $attempt->total_marks }}</td>
                                <td>{{ $attempt->obtained_marks ?? '-' }}</td>

                                <td>
                                    @if(is_null($attempt->obtained_marks))
                                        <span class="badge badge-warning">
                                            Not Evaluated
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Evaluated
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('teacher.evaluate.test', $attempt->id) }}" class="btn btn-primary">
                                        Evaluate
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
        });
    </script>

@endpush