@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Test Questions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Test Questions</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Uploading content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title px-1">Upload Test Questions</h3>
                        <a href="{{ asset('build/assets/files/objective.xlsx') }}" class="btn btn-info mx-3" download>
                            objective Demo
                        </a>
                        <a href="{{ asset('build/assets/files/subjective.xlsx') }}" class="btn btn-info" download>
                            Subjective Demo
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('upload.test.questions')  }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <select name="board_id" id="board_id" class="form-control">
                                        <option value="">Select Board</option>
                                        @foreach($boards as $board)
                                            <option value="{{ $board->id }}">
                                                {{ $board->board_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="board_id_error" class="text-danger">
                                        @error('board_id') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <select name="subject_id" class="form-control subject-select">
                                        <option value="">Select Subject</option>

                                    </select>
                                    <span class="text-danger">
                                        @error('subject_id') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <select name="book_id" class="form-control book-select">
                                        <option value="">Select Book</option>
                                    </select>
                                    <span class="text-danger">
                                        @error('book_id') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select name="type" class="form-control">
                                        <option value="">Select Test Type</option>
                                        <option value="objective" {{ old('type') == 'objective' ? 'selected' : '' }}>Objective</option>
                                        <option value="subjective" {{ old('type') == 'subjective' ? 'selected' : '' }}>
                                            Subjective</option>
                                    </select>
                                    <span class="text-danger">@error('type') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-4">
                                    {{-- <select name="test_name" class="form-control">
                                    </select> --}}
                                    <input type="text" name="test_name" class="form-control" value="{{ old('test_name') }}"
                                        placeholder="Enter Test Name">
                                    <span class="text-danger">
                                        @error('test_name') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="file" name="questions_sheet" class="form-control">
                                    <span class="text-danger">@error('questions_sheet') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <textarea name="description" class="form-control" rows="2"></textarea>
                                    <span class="text-danger">@error('description') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Upload Test
                            </button>
                        </form>
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



                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title">Test Questions</h3>
                                {{-- <button type="button" data-toggle="modal" data-target="#add-teacher-modal"
                                    class='btn btn-success'><i class="fas fa-plus"></i>
                                    Add Teacher</button> --}}
                            </div> 
                            <div class="card-body">
                                <table id="teacher-table" class="table table-bordered table-hover table-auto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book</th>
                                            <th>Class</th>
                                            <th>Objective Tests</th>
                                            <th>Subjective Tests</th>
                                        </tr>
                                    </thead>
                                    <tbody id="teacher">
                                        @foreach ($testTemplates as $bookId => $tests)
                                            @php
    $book = $tests->first()->book;
    $class = $tests->first()->class;
    $objectiveTests = $tests->where('type', 'objective');
    $subjectiveTests = $tests->where('type', 'subjective');
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $book->book_name }}</td>
                                                <td>{{ $class->class_name }}</td>

                                                {{-- Objective Column --}}      
                                                <td>
                                                    @foreach ($objectiveTests as $test)
                                                        <div class="mb-2 d-flex align-items-center">
                                                            <button type="button" data-id="{{ $test->id }}"
                                                                class="btn btn-sm btn-success view-questions-btn">
                                                                {{ $test->test_name }}
                                                            </button>

                                                            <button class="btn btn-sm btn-secondary mx-2">
                                                                {{ $test->questions->count() }}
                                                            </button>

                                                            <button type="button" data-id="{{ $test->id }}"
                                                                class="btn btn-sm btn-danger delete-btn">
                                                                <i class="fas fa-trash"></i>
                                                            </button>

                                                        </div>
                                                    @endforeach
                                                </td>

                                                {{-- Subjective Column --}}
                                                <td>
                                                    @foreach ($subjectiveTests as $test)
                                                    <div class="mb-2 d-flex align-items-center">

                                                        <button type="button" data-id="{{ $test->id }}"
                                                            class="btn btn-sm btn-info view-questions-btn">
                                                            {{ $test->test_name }}
                                                        </button>

                                                        <button class="btn btn-sm btn-secondary mx-2">
                                                            {{ $test->questions->count() }}
                                                        </button>

                                                        <button type="button" data-id="{{ $test->id }}"
                                                            class="btn btn-sm btn-danger delete-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>

                                                    </div>
                                                    @endforeach
                                                </td>

                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- View Questions Modal -->
        <div class="modal fade" id="view-questions-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Test Questions</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="questions-container">
                        Loading...
                    </div>

                </div>
            </div>
        </div>

        <!-- Delete Test Modal -->
        <div class="modal fade" id="delete-test-template-modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">Delete Test</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this test?
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

    </div>

@endsection

@push('scripts')
    <script>

        $(document).ready(function () {

            // Load subjects on board change
            $('#board_id').on('change', function () {
                let boardId = $(this).val();

                $('.subject-select').html('<option>Loading...</option>');
                $('.book-select').html('<option value="">Select Book</option>');

                if (!boardId) return;

                $.get('/admin/get-subjects/' + boardId, function (subjects) {
                    let options = '<option value="">Select Subject</option>';
                    $.each(subjects, function (_, subject) {
                        options += `<option value="${subject.id}">${subject.subject_name}</option>`;
                    });

                    $('.subject-select').html(options);
                });
            });

            // Load books when subject changes
            $(document).on('change', '.subject-select', function () {
                let subjectId = $(this).val();

                $('.book-select').html('<option value="">Loading...</option>');

                if (!subjectId) return;

                $.get('/admin/get-books/' + subjectId, function (books) {
                    let options = '<option value="">Select Book</option>';
                    $.each(books, function (_, book) {
                        options += `<option value="${book.id}">${book.book_name}</option>`;
                    });
                    $('.book-select').html(options);
                });
            });

            $(document).on('click', '.view-questions-btn', function () {

                let testId = $(this).data('id');

                $('#questions-container').html('Loading...');

                $('#view-questions-modal').modal('show');

                $.get('/admin/test/' + testId + '/questions', function (questions) {

                    let html = '';

                    if (questions.length === 0) {
                        html = '<p>No questions found.</p>';
                    } else {

                        $.each(questions, function (index, q) {

                            html += `<p><strong>Q ${index + 1}. ${q.question}</strong></p>`;

                            if (q.test_template.type === 'objective') {

                                html += `
                                                                                                                                                                                                                                                                    <p>A. ${q.a}</p>
                                                                                                                                                                                                                                                                    <p>B. ${q.b}</p>
                                                                                                                                                                                                                                                                    <p>C. ${q.c}</p>
                                                                                                                                                                                                                                                                    <p>D. ${q.d}</p>
                                                                                                                                                                                                                                                                    <p><strong>Correct Answer: ${q.answer}</strong></p>
                                                                                                                                                                                                                                                                    <p>Marks: ${q.marks}</p>
                                                                                                                                                                                                                                                                `;

                            }
                            else {
                                html += ` <p>Marks: ${q.marks}</p>`;
                            }

                            html += `<hr>`;
                        });
                    }

                    $('#questions-container').html(html);
                });
            });

            $(document).on('click', '.delete-btn', function () {

                let id = $(this).data('id');

                let url = "{{ route('delete.test.template', ':id') }}";
                url = url.replace(':id', id);

                $('#delete-form').attr('action', url);

                $('#delete-test-template-modal').modal('show');
            });
        });
    </script>
@endpush