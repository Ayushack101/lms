@extends('layouts.app')

@section('content')
    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Student</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                            <li class="breadcrumb-item active">Edit Students</li>
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
                        <h3 class="card-title">Edit Students</h3>
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
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Row 1 --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Student Name *</label>
                <input type="text"
                       name="student_name"
                       class="form-control"
                       value="{{ old('student_name', $student->student_name) }}">

                @error('student_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mobile *</label>
                <input type="text"
                       name="student_mobile"
                       class="form-control"
                       value="{{ old('student_mobile', $student->student_mobile) }}">

                @error('student_mobile')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Email *</label>
                <input type="email"
                       name="student_email"
                       class="form-control"
                       value="{{ old('student_email', $student->user?->email) }}">

                @error('student_email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Address *</label>
                <textarea name="address"
                          class="form-control"
                          rows="2">{{ old('address', $student->address) }}</textarea>

                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Row 3 --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">School Name *</label>
                <input type="text"
                       name="school_name"
                       class="form-control"
                       value="{{ old('school_name', $student->school_name) }}">

                @error('school_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status *</label>

                <select name="status" class="form-control">
                    <option value="">Select Status</option>

                    <option value="active"
                        {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Row 4 --}}
        <div class="row">

            {{-- Class --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Class Name *</label>

                <select name="class_id" id="class_id" class="form-control">
                    <option value="">Select Class</option>

                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>

                @error('class_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Section Name *</label>

                <select name="section_id" class="form-control section-select">
                    <option value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}"
                            {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>
                            {{ $section->section_name }}
                        </option>
                    @endforeach
                </select>

                @error('section_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Teacher --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Teacher Name *</label>

                <select name="teacher_id" class="form-control">
                    <option value="">Select Teacher</option>

                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ old('teacher_id', $student->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->teacher_name }}
                        </option>
                    @endforeach
                </select>

                @error('teacher_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Password & confirmed password --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="student_password" class="form-control" autocomplete="new-password">
                <small class="form-text text-muted">Leave blank to keep the current password.</small>
                <span class="text-danger">
                    @error('student_password')
                        {{ $message }}
                    @enderror
                </span>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="student_password_confirmation" class="form-control" autocomplete="new-password">
            </div>
        </div>

        {{-- Button --}}
        <button type="submit" class="btn btn-success">
            Update Student
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

            $('#class_id').on('change', function () {
                let classId = $(this).val();

                if (!classId) {
                    alert("Please select class first");
                    return;
                }

                $('.section-select').html('<option value="">Select Section</option>');

                $.ajax({
                    url: '/admin/get-sections-by-class/' + classId  ,
                    type: 'GET',
                    success: function (sections) {

                        let sectionOptions = '<option value="">Select Section</option>';
                        let data = sections?.sections || sections;
                        $.each(data, function (i, section) {
                            sectionOptions +=
                                `<option value="${section.id}">${section.section_name}</option>`;
                        });

                        $('.section-select').html(sectionOptions);
                    }
                });
            });

        });
    </script>
@endpush
