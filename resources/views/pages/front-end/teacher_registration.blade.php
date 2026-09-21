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
    <div class="auth-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <div>
                <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo" height="40">
            </div>

            <!-- Login link -->
            <div>
                <a href="{{ route('home.login') }}" class="text-decoration-none fw-semibold">
                    Login
                </a>
            </div>
        </div>
    </div>
    <!-- Registration Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8">

                <div class="card auth-card pb-4" style="border-radius:12px;">
                    <div class="card-header text-white text-center py-3 gradient-header">
                        <h2 class="mb-0">New Teacher Register</h2>
                    </div>

                    {{-- Success message --}}
                    @if (session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body px-4">
                        <form action="{{ route('home.teacher.registration.store') }}" method="POST">
                            @csrf

                            <!-- Row 1 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
                                    <span class="text-danger" id="full_name_error">
                                        @error('full_name') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile *</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                    <span class="text-danger" id="mobile_error">
                                        @error('mobile') {{ $message }} @enderror
                                    </span>
                                </div>

                            </div>

                            <!-- Row 2 -->
                            <div class="row ">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">School Name *</label>
                                    <input type="text" name="school_name" class="form-control"
                                        value="{{ old('school_name') }}">
                                    <span class="text-danger">
                                        @error('school_name') {{ $message }} @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">School Address *</label>
                                    <textarea name="school_address" class="form-control"
                                        rows="2">{{ old('school_address') }}</textarea>
                                    <span class="text-danger">
                                        @error('school_address') {{ $message }} @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address(Personal) *</label>
                                    <textarea name="personal_address" class="form-control"
                                        rows="2">{{ old('personal_address') }}</textarea>
                                    <span class="text-danger">
                                        @error('personal_address') {{ $message }} @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Principal's Name *</label>
                                    <input type="text" name="principal_name" class="form-control"
                                        value="{{ old('principal_name') }}">
                                    <span class="text-danger">
                                        @error('principal_name') {{ $message }} @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email(School) *</label>
                                    <input type="email" name="personal_email" class="form-control"
                                        value="{{ old('personal_email') }}">
                                    <span class="text-danger">
                                        @error('personal_email') {{ $message }} @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">DOB *</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                    <span class="text-danger">
                                        @error('dob') {{ $message }} @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Row 5 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Session Start *</label>
                                    <select name="session_start" class="form-control">
                                        <option value="">-- Select Slot --</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                    <span class="text-danger">
                                        @error('session_start') {{ $message }} @enderror
                                    </span>
                                </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Board *</label>
                                    <select name="board_id" id="board_id" class="form-control">
                                        <option value="">Select Board</option>
                                        @foreach($boards as $board)
                                            <option value="{{ $board->id }}" {{ old('board_id') == $board->id ? 'selected' : '' }}>
                                                {{ $board->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span id="board_id_error" class="text-danger">
                                        @error('board_id') {{ $message }} @enderror
                                    </span>
                                    </div>
                            </div>

                            <div id="subject-book-wrapper">

                                <div class="row subject-book-row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Subject *</label>
                                        <select name="subject_books[0][subject_id]" class="form-control subject-select">
                                            <option value="">Select Subject</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Books *</label>
                                        <select name="subject_books[0][book_ids][]" class="select2bs4 form-control book-select" multiple>
                                        </select>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-row d-none">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <button type="button" id="add-more" class="btn btn-outline-primary btn-sm mb-3">
                                + Add Another Subject
                            </button>


                            <!-- Row 6 -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Representative Name *</label>
                                    <input type="text" name="representative_name" class="form-control" value="{{ old('representative_name') }}">
                                    <span class="text-danger">
                                        @error('representative_name') {{ $message }} @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Representative Contact *</label>
                                    <input type="text" name="representative_contact" class="form-control" value="{{ old('representative_contact') }}">
                                    <span class="text-danger">
                                        @error('representative_contact') {{ $message }} @enderror
                                    </span>
                                </div>
                            </div>

                            {{-- Row 7 --}}
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password *</label>
                                <input type="text" name="password" class="form-control" value="{{ old('password') }}">
                                <span class="text-danger">
                                    @error('password') {{ $message }} @enderror
                                </span>
                            </div>
                            </div>
                            <!-- Register Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn">
                                    Register
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let index = 0;

        $(document).ready(function () {

            // Load subjects on board change
            $('#board_id').on('change', function () {
                let boardId = $(this).val();

                if (!boardId) return;

                $.get('/get-subjects-by-board/' + boardId, function (subjects) {
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
                let bookSelect = $(this).closest('.subject-book-row').find('.book-select');

                bookSelect.html('');

                if (!subjectId) return;

                $.get('/get-books-by-subject/' + subjectId, function (books) {
                    $.each(books, function (_, book) {
                        bookSelect.append(
                            `<option value="${book.id}">${book.book_name}</option>`
                        );
                    });
                });
            });

            // Add new subject row
            $('#add-more').on('click', function () {
                index++;

                let subjectOptions = $('.subject-select:first').html();

                let row = `
            <div class="row subject-book-row mb-3">
                <div class="col-md-6">
                    <select name="subject_books[${index}][subject_id]"
                            class="form-control subject-select">
                        ${subjectOptions}
                    </select>
                </div>

                <div class="col-md-6">
                    <select name="subject_books[${index}][book_ids][]"
                            class="select2bs4 form-control book-select"
                            multiple></select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button"
                            class="btn btn-danger remove-row">
                        Remove
                    </button>
                </div>
            </div>`;

                $('#subject-book-wrapper').append(row);

                // re-init select2 for new elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
            });

            // Remove row
            $(document).on('click', '.remove-row', function () {
                $(this).closest('.subject-book-row').remove();
            });

        });
    </script>

@endpush