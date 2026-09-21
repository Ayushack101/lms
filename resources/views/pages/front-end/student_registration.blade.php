@extends('layouts.frontend')
@section('pageCss')
    <style>
        body {
            background-color: #f8f9fa !important;
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
                        <h2 class="mb-0">New Student Register</h2>
                    </div>

                    {{-- Success message --}}
                    @if (session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-body px-4">
                        <form action="{{ route('home.student.registration.store') }}" method="POST">
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    <span class="text-danger" id="email_error">
                                        @error('email') {{ $message }} @enderror
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="text" name="password" class="form-control" value="{{ old('password') }}">
                                    <span class="text-danger" id="password_error">
                                        @error('password') {{ $message }} @enderror
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
                                <label class="form-label">Address(Personal) *</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                                <span class="text-danger">
                                    @error('address') {{ $message }} @enderror
                                </span>
                            </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Class *</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span id="class_id_error" class="text-danger">
                                        @error('class_id') {{ $message }} @enderror
                                    </span>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Section *</label>
                                        <select name="section_id" id="section_id" class="form-control">
                                            <option value="">Select Section</option>
                                        </select>

                                        <span id="section_id_error" class="text-danger">
                                            @error('section_id') {{ $message }} @enderror
                                        </span>
                                    </div>
                            </div>


                            {{-- Row 4 --}}
                            <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teacher Code *</label>
                                <input type="text" name="teacher_code" class="form-control" value="{{ old('teacher_code') }}">
                                <span class="text-danger">
                                    @error('teacher_code') {{ $message }} @enderror
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

                        if (sections.length > 0) {
                            $.each(sections, function (index, section) {
                                options += `
                                    <option value="${section.id}">
                                        ${section.section_name}
                                    </option>`;
                            });
                        }

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