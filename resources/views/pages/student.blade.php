@extends('layouts.app')

@section('content')
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('build/assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
            height="60" width="60">
    </div>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Students</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('view.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title">All Students</h3>
                                {{-- <button type="button" data-toggle="modal" data-target="#add-teacher-modal"
                                    class='btn btn-success'><i class="fas fa-plus"></i>
                                    Add Teacher</button> --}}
                            </div>
                            <div class="card-body">
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
                                            <th>Teacher Code</th>
                                            <th>School Name</th>
                                            <th>Status</th>
                                            <th>Create At</th>
                                            <th>Action</th>
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
                                                <td>{{ $student->teacher_code }}</td>
                                                <td>{{ $student->school_name }}</td>
                                                <th>{{ $student->status }}</th>
                                                <td>{{ $student->created_at->format('d M Y') }}</td>
                                                <td><a href="{{ route('edit.student', $student->id) }}"><button type="button" 
                                                        class='btn btn-primary edit-btn'> <i class="fas fa-edit"></i></button></a>
                                                    <button type="button" data-toggle="modal" data-target="#delete-student-modal"
                                                        data-id="{{ $student->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i></button>
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

        {{-- Delete Student Modal --}}
        <div class="modal fade" id="delete-student-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Student?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="delete-student" data-id="" class="btn btn-danger"><a href="#" id="confirm-delete-btn" >Yes, Delete</a></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            // Sweet Alert Declaration
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000
            });

            // Delete Student
            var deleteId;
            $(document).on("click", ".delete-btn", function () {
                deleteId = $(this).data('id');
               let url = "{{ route('delete.student', ':id') }}";
                url = url.replace(':id', deleteId);

                $("#confirm-delete-btn").attr("href", url);

            });

        });
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