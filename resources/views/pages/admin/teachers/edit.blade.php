@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Subject</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('teachers.index') }}">Teachers</a></li>
                            <li class="breadcrumb-item active">Edit Teacher</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Edit Subject</h3>
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

                    <div class="card-body">
                        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="teacher_name" class="form-control"
                                        value="{{ old('teacher_name', $teacher->teacher_name) }}">
                                    <span class="text-danger">
                                        @error('teacher_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile *</label>
                                    <input type="text" name="teacher_mobile" class="form-control"
                                        value="{{ old('teacher_mobile', $teacher->teacher_mobile) }}">
                                    <span class="text-danger">
                                        @error('teacher_mobile')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">School Name *</label>
                                    <input type="text" name="school_name" class="form-control"
                                        value="{{ old('school_name', $teacher->school_name) }}">
                                    <span class="text-danger">
                                        @error('school_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">School Address *</label>
                                    <textarea name="school_address" class="form-control" rows="2">{{ old('school_address', $teacher->school_address) }}</textarea>
                                    <span class="text-danger">
                                        @error('school_address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address(Personal) *</label>
                                    <textarea name="personal_address" class="form-control" rows="2">{{ old('personal_address', $teacher->personal_address) }}</textarea>
                                    <span class="text-danger">
                                        @error('personal_address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Principal's Name *</label>
                                    <input type="text" name="principal_name" class="form-control"
                                        value="{{ old('principal_name', $teacher->principal_name) }}">
                                    <span class="text-danger">
                                        @error('principal_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="teacher_email" class="form-control"
                                        value="{{ old('teacher_email', $teacher->user->email) }}">
                                    <span class="text-danger">
                                        @error('teacher_email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">DOB *</label>
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ old('dob', $teacher->dob) }}">
                                    <span class="text-danger">
                                        @error('dob')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Session Start *</label>
                                    <select name="session_start" class="form-control">
                                        <option value="">-- Select Slot --</option>
                                        @php
                                            $months = [
                                                'January',
                                                'February',
                                                'March',
                                                'April',
                                                'May',
                                                'June',
                                                'July',
                                                'August',
                                                'September',
                                                'October',
                                                'November',
                                                'December',
                                            ];
                                        @endphp
                                        @foreach ($months as $month)
                                            <option value="{{ $month }}"
                                                {{ old('session_start', $teacher->session_start) == $month ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('session_start')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teacher Code *</label>
                                    <input type="text" name="teacher_code" class="form-control"
                                        value="{{ old('teacher_code', $teacher->teacher_code) }}" disabled>
                                    <span class="text-danger">
                                        @error('teacher_code')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="active"
                                            {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                    <span class="text-danger">
                                        @error('status')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Board *</label>
                                    <select name="board_id" id="board_id" class="form-control">
                                        <option value="">Select Board</option>
                                        @foreach ($boards as $board)
                                            <option value="{{ $board->id }}"
                                                {{ old('board_id', $teacher->board_id) == $board->id ? 'selected' : '' }}>
                                                {{ $board->board_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger">
                                        @error('board_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            @php
                                $subjectBookRows = old('subject_books', $subjectBooks);
                            @endphp

                            {{-- <!-- Subject Book Wrapper --> --}}
                            <div id="subject-book-wrapper">
                                @foreach ($subjectBookRows as $index => $row)
                                    @php
                                        $selectedSubjectId = $row['subject_id'] ?? null;
                                        $selectedBookIds = $row['book_ids'] ?? [];
                                    @endphp
                                    <div class="row subject-book-row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Subject *</label>
                                            <select name="subject_books[{{ $index }}][subject_id]"
                                                class="form-control subject-select">
                                                <option value="">Select Subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->subject_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error("subject_books.$index.subject_id")
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Books *</label>
                                            <select name="subject_books[{{ $index }}][book_ids][]"
                                                class="select2bs4 form-control book-select" multiple>
                                                @foreach ($books->where('subject_id', $selectedSubjectId) as $book)
                                                    <option value="{{ $book->id }}"
                                                        {{ in_array($book->id, $selectedBookIds) ? 'selected' : '' }}>
                                                        {{ $book->book_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error("subject_books.$index.book_ids")
                                                    {{ $message }}
                                                @enderror
                                                @error("subject_books.$index.book_ids.*")
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button"
                                                class="btn btn-danger remove-row {{ $index == 0 ? 'd-none' : '' }}">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-danger">
                                @error('subject_books')
                                    {{ $message }}
                                @enderror
                            </span>  
                            <button type="button" id="add-more" class="btn btn-outline-primary btn-sm mb-3">
                                + Add Another Subject
                            </button>

                            {{-- <!-- Classes --> --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Classes *</label>
                                    <select name="class_ids[]" class="select2bs4 form-control" multiple>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" @selected(in_array($class->id, old('class_ids', $teacher->classes->pluck('id')->all())))>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('class_ids')
                                            {{ $message }}
                                        @enderror
                                        @error('class_ids.*')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>



                            {{-- <!-- Representative --> --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Representative Name *</label>
                                    <input type="text" name="representative_name" class="form-control"
                                        value="{{ old('representative_name', $teacher->representative_name) }}">
                                    <span class="text-danger">
                                        @error('representative_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Representative Contact *</label>
                                    <input type="text" name="representative_contact" class="form-control"
                                        value="{{ old('representative_contact', $teacher->representative_contact) }}">
                                    <span class="text-danger">
                                        @error('representative_contact')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="teacher_password" class="form-control"
                                        autocomplete="new-password">
                                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                                    <span class="text-danger">
                                        @error('teacher_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="teacher_password_confirmation" class="form-control"
                                        autocomplete="new-password">
                                </div>
                            </div>


                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Update Teacher
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            let index = {{ count($subjectBookRows) }};

            // Board change -> reload subjects
            $('#board_id').on('change', function() {
                let boardId = $(this).val();

                if (!boardId) {
                    alert("Please select board first");
                    return;
                }

                $('.subject-select').html('<option value="">Loading...</option>');
                $('.book-select').html('<option value="">Select Book</option>');

                $.ajax({
                    url: '/admin/get-subjects-by-board/' + boardId,
                    type: 'GET',
                    success: function(subjects) {

                        let subjectOptions = '<option value="">Select Subject</option>';
                        let data = subjects?.subjects || subjects;
                        $.each(data, function(i, subject) {
                            subjectOptions +=
                                `<option value="${subject.id}">${subject.subject_name}</option>`;
                        });

                        $('.subject-select').html(subjectOptions);
                        $('.book-select').html('');
                    }
                });
            });

            // Subject change -> load books
            $(document).on('change', '.subject-select', function() {
                let subjectId = $(this).val();
                let bookSelect = $(this).closest('.subject-book-row').find('.book-select');

                bookSelect.html('').prop('disabled', true);

                if (!subjectId) return;

                $.ajax({
                    url: '/admin/get-books-by-subject/' + subjectId,
                    type: 'GET',
                    success: function(books) {
                        let options = '';
                        let data = books?.books || books;
                        console.log(data);
                        $.each(data, function(i, book) {
                            options +=
                                `<option value="${book.id}">${book.book_name}</option>`;
                        });

                        bookSelect.html(options).prop('disabled', false);

                        // re-init select2
                        bookSelect.select2({
                            theme: 'bootstrap4'
                        });
                    }
                });
            });

            // Add new row
            $('#add-more').on('click', function() {

                let subjectOptions = '';

                @foreach ($subjects as $subject)
                    subjectOptions +=
                        `<option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>`;
                @endforeach

                let row =
                    `
                                                                                                                                                            <div class="row subject-book-row mb-3">
                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                    <label class="form-label">Subject *</label>
                                                                                                                                                                    <select name="subject_books[${index}][subject_id]"
                                                                                                                                                                            class="form-control subject-select">
                                                                                                                                                                        <option value="">Select Subject</option>
                                                                                                                                                                        ${subjectOptions}
                                                                                                                                                                    </select>
                                                                                                                                                                </div>

                                                                                                                                                                <div class="col-md-6">
                                                                                                                                                                    <label class="form-label">Books *</label>
                                                                                                                                                                    <select name="subject_books[${index}][book_ids][]"
                                                                                                                                                                            class="select2bs4 form-control book-select"
                                                                                                                                                                            multiple></select>
                                                                                                                                                                </div>

                                                                                                                                                                <div class="col-md-2 d-flex align-items-end">
                                                                                                                                                                    <button type="button" class="btn btn-danger remove-row">
                                                                                                                                                                        Remove
                                                                                                                                                                    </button>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        `;

                $('#subject-book-wrapper').append(row);

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                index++;
            });

            // Remove row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.subject-book-row').remove();
            });

        });
    </script>
@endpush
