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
            <!-- <div class="breadcrumbs">-->
            <!--  CBSE / AK Tech Education / Class 9 /-->
            <!--  <strong>E-Book \ Flipbook</strong>-->
            <!--</div> -->
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

                <!--<span class="teacher-btn-icon">T</span>-->
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

        {{-- Student Table --}}
        <div class="card">
            <div class="card-header gradient-header text-white">
                <h5 class="mb-0">Student Records</h5>
            </div>

            <div class="card-body">
                <table id="student-table" class="table table-bordered table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Teacher name</th>
                            <th>School Name</th>
                            <th>Status</th>
                            <th>Create At</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody id="student">
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->mobile }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->class->class_name ?? '' }}</td>
                                <td>{{ $student->section->section_name ?? '' }}</td>
                                <td>{{ $student->teacher->full_name ?? '' }}</td>
                                <td>{{ $student->school_name }}</td>
                                <th>{{ $student->status }}</th>
                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                {{-- <td><a href="{{ route('edit.student', $student->id) }}"><button type="button"
                                            class='btn btn-primary edit-btn'> <i class="fas fa-edit"></i></button></a>
                                    <button type="button" data-toggle="modal" data-target="#delete-student-modal"
                                        data-id="{{ $student->id }}" class='btn btn-danger mx-2 delete-btn'>
                                        <i class="fas fa-trash"></i></button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{-- <div class="d-flex justify-content-center">
                    {{ $students->links() }}
                </div> --}}
            </div>
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