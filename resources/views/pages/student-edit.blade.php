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
                            <li class="breadcrumb-item"><a href="{{ route('view.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('view.student') }}">Students</a></li>
                            <li class="breadcrumb-item active">Edit Student</li>
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
                        <h3 class="card-title">Edit Student</h3>
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
                        <form action="{{ route('update.student') }}" method="POST">
                            @csrf

                            <input type="hidden" name="student_id" value="{{ $student->id }}">

                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Full Name *</label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="{{ old('full_name', $student->full_name) }}">
                                    <span class="text-danger">@error('full_name') {{ $message }} @enderror</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Mobile *</label>
                                    <input type="text" name="mobile" class="form-control"
                                        value="{{ old('mobile', $student->mobile) }}">
                                    <span class="text-danger">@error('mobile') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>School Name *</label>
                                    <input type="text" name="school_name" class="form-control"
                                        value="{{ old('school_name', $student->school_name) }}">
                                    <span class="text-danger">@error('school_name') {{ $message }} @enderror</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Address *</label>
                                    <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
                                    <span class="text-danger">@error('address') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Row 3 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ old('status', $student->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    <span class="text-danger">@error('status') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email *</label>
                                    <textarea name="email" class="form-control" rows="2">{{ old('email', $student->email) }}</textarea>
                                    <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Row 4 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Class *</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('class_id') {{ $message }} @enderror</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Section *</label>
                                    <select name="section_id" id="section_id" class="form-control">
                                        <option value="">Select Section</option>

                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>
                                                {{ $section->section_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('section_id') {{ $message }} @enderror</span>
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
$(document).ready(function () {

    $('#class_id').on('change', function () {

        let classId = $(this).val();
        $('#section_id').html('<option value="">Loading...</option>');

        if (!classId) {
            $('#section_id').html('<option value="">Select Section</option>');
            return;
        }

        $.ajax({
            url: '/get-sections-by-class/' + classId,
            type: 'GET',
            success: function (sections) {

                let options = '<option value="">Select Section</option>';

                $.each(sections, function (index, section) {
                    options += `<option value="${section.id}">${section.section_name}</option>`;
                });

                $('#section_id').html(options);
            },
            error: function () {
                $('#section_id').html('<option value="">Failed to load sections</option>');
            }
        });

    });

});
</script>
@endpush
