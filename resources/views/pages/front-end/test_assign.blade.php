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

        {{-- Assign Test --}}
        <div class="card">
            <div class="card-header gradient-header text-white">
                <h5 class="mb-0">Assign Test</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('teacher.assign.store') }}" method="POST">
                    @csrf

                    {{-- Row 1 --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" id="subject_id" class="form-control">
                                <option value="">Select Subject</option>
                                @foreach($teacherSubjects as $subject)
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>

                            <span id="subject_id_error" class="text-danger">
                                @error('subject_id') {{ $message }} @enderror
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label for="book_id">Book</label>
                            <select name="book_id" id="book_id" class="form-control">
                                <option value="">Select Book</option>
                            </select>
                            <span class="text-danger">
                                @error('book_id') {{ $message }} @enderror
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label for="class_id">Class</label>
                            <select name="class_id" id="class_id" class="form-control">
                                <option value="">Select Class</option>
                            </select>
                            <span class="text-danger">
                                @error('class_id') {{ $message }} @enderror
                            </span>
                        </div>

                        <div class="col-md-3">
                            <label for="section_id">Section</label>
                            <select name="section_id" id="section_id" class="form-control section-select">
                                <option value="">Select Section</option>
                            </select>
                            <span class="text-danger">
                                @error('section_id') {{ $message }} @enderror
                            </span>
                        </div>

                    </div>

                    {{-- Row 2 --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="test_template_id">Test</label>
                            <select name="test_template_id" id="test_template_id" class="form-control">
                                <option value="">Select Test</option>
                            </select>
                            <span class="text-danger">@error('test_template_id') {{ $message }} @enderror</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                            <span class="text-danger">@error('start_date') {{ $message }} @enderror</span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                            <span class="text-danger">@error('end_date') {{ $message }} @enderror</span>
                        </div>
                    </div>

                    {{-- Button --}}
                    <button type="submit" class="btn btn-success">
                        Assign Test
                    </button>

                </form>
            </div>
        </div>

        {{-- View Assign Test --}}

        <div class="card my-5">
            <div class="card-header gradient-header text-white">
                <h5 class="mb-0">Test Assigned</h5>
            </div>

            <div class="card-body">
                <table id="test-table" class="table table-bordered table-hover table-auto">
                    <thead>
                        <tr>
                            <th>Test </th>
                            <th>Book</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="student">
                        @foreach ($assignedTests as $test)
                            <tr>
                                <td>{{ $test->testTemplate->test_name }}</td>
                                <td>{{ $test->book->book_name }}</td>
                                <td>{{ $test->class->class_name }}</td>
                                <td>{{ $test->section->section_name }}</td>
                                <td>{{ $test->start_date }}</td>
                                <td>{{ $test->end_date  }}</td>
                                <th>{{ $test->status }}</th>
                                <th><a href="{{ route('teacher.test.attempts', $test->id) }}"><Button
                                            class="btn btn-info">View</Button></a></th>
                                <td>
                                    <div class="d-flex">
                                        @php
                                            if ($test->status == 'active' || $test->status == 'pending') {
                                        @endphp
                                        <form action="{{ route('change.assigned.test.status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="test_id" value="{{ $test->id }}">
                                            <button type="submit" class='btn btn-primary edit-btn'>Change
                                                Status</button>
                                        </form>
                                        @php
                                            }
                                        @endphp
                                        <button type="button" data-toggle="modal" data-target="#delete-test-modal"
                                            data-id="{{ $test->id }}" class='btn btn-danger mx-2 delete-btn'>
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Test Modal -->
    <div class="modal fade" id="delete-test-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Delete Assigned Test</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete this Assigned test?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <form id="delete-form" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->


@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#subject_id').change(function () {
                let subjectId = $(this).val();

                $('#book_id').html('<option value="">Loading...</option>');
                $('#class_id').html('<option value="">Select Class</option>');
                $('#section_id').html('<option value="">Select Section</option>');
                $('#test_template_id').html('<option value="">Select Test</option>');

                $.get('/teacher/books/' + subjectId, function (books) {

                    let options = '<option value="">Select Book</option>';

                    $.each(books, function (_, book) {
                        options += `<option value="${book.id}">${book.book_name}</option>`;
                    });

                    $('#book_id').html(options);
                });
            });
            $('#book_id').change(function () {

                let bookId = $(this).val();

                $('#class_id').html('<option value="">Loading...</option>');
                $('#section_id').html('<option value="">Select Section</option>');
                $('#test_template_id').html('<option value="">Select Test</option>');

                // Class
                $.get('/teacher/class/' + bookId, function (classData) {
                    $('#class_id').html(`<option value="${classData.id}">${classData.class_name}</option>`);
                });

                // Sections
                $.get('/teacher/sections/' + bookId, function (sections) {

                    let options = '<option value="">Select Section</option>';

                    $.each(sections, function (_, section) {
                        options += `<option value="${section.id}">${section.section_name}</option>`;
                    });

                    $('#section_id').html(options);
                });

                // Tests
                $.get('/teacher/tests/' + bookId, function (tests) {

                    let options = '<option value="">Select Test</option>';

                    $.each(tests, function (_, test) {
                        options += `<option value="${test.id}">${test.test_name}</option>`;
                    });

                    $('#test_template_id').html(options);
                });

            });

            $(document).on('click', '.delete-btn', function () {
                console.log('Delete button clicked');
                let id = $(this).data('id');

                let url = "{{ route('delete.assigned.test', ':id') }}";
                url = url.replace(':id', id);

                $('#delete-form').attr('action', url);

                //$('#delete-test-modal').modal('show');
            });
        });
    </script>

@endpush