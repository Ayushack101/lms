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
                Student Section
            </a>
            {{-- <a href="{{ route('teacher.test.assign') }}" class="nav-link">
                Assign Test
            </a> --}}
            <a href="{{ route('home.logout') }}" class="nav-link">
                Logout
            </a>

            <span class="teacher-btn" style="cursor: auto !important;">

                <!--<span class="teacher-btn-icon">T</span>-->
                {{ $student->full_name }}

            </span>

        </div>
    </div>

    <!-- Student Records  -->
    <div class="container-fluid mt-5 px-5">
        <h2 class="mb-4">Student Dashboard</h2>

        <div class="row mb-4">
            <div class="col-md-3">
                <span class="teacher-btn" style="cursor: auto !important;">
                    Teacher Code: {{ $student->teacher_code }}
                </span>

            </div>
        </div>

        {{-- Student Table --}}
        <div class="row mb-4">
            @foreach ($assignedTests as $test)

                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header gradient-header text-white">
                            <h6 class="mb-0 text-center">{{ $test->testTemplate->test_name }}</h6>
                        </div>

                        <div class="card-body">
                            <p><strong>Book:</strong> {{ $test->book->book_name }}</p>
                            <p><strong>Class:</strong> {{ $test->class->class_name }} {{ $test->section->section_name }}
                            </p>
                            <p><strong>Type:</strong> {{ $test->testTemplate->type }}</p>

                            @if ($test->status === 'active' && now()->lessThanOrEqualTo($test->end_date))
                                <a href="{{ route('student.take.test', $test->test_template_id) }}">
                                    <button class="btn btn-primary btn-block">
                                        Take Test
                                    </button>
                                </a>
                            @else
                                <a href="#">
                                    <button disabled class="btn btn-primary btn-block">
                                        Take Test
                                    </button>
                                </a>
                            @endif

                            <p class="mt-1 text-center text-muted">Can be attempted until {{ $test->end_date }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->


@endsection

@push('scripts')
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#student-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>

@endpush