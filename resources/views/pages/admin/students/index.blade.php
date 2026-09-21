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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
                                <div class="d-flex">
                                    <form action="{{ route('students.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search student..." value="{{ request('search') }}">

                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
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

                            <div class="card-body">
                                <table id="students-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>address</th>
                                            <th>School Name</th>
                                            <th>Status</th>
                                            <th>Class</th>
                                            <th>Teacher Code</th>
                                            <th>Teacher</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="student">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $student->student_name }}</td>
                                                <td>{{ $student->student_mobile }}</td>
                                                <td>{{ $student->user->email ?? '' }}</td>
                                                <td>{{ $student->address }}</td>
                                                <td>{{ $student->school_name }}</td>
                                                <td>{{ $student->status }}</td>
                                                <td>{{ $student->class->class_name ?? '' }}</td>
                                                <td>{{ $student->teacher_code }}</td>
                                                <td>{{ $student->teacher->teacher_name ?? '' }}</td>  
                                                <td>
                                                    <a href="{{ route('students.edit', $student->id, $student->teacher->teacher_name) }}"><button type="button"
                                                            class='btn btn-primary edit-btn'> <i
                                                                class="fas fa-edit"></i></button></a>

                                                    <button type="button" data-toggle="modal" data-target="#delete-student-modal"
                                                        data-id="{{ $student->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $students->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete student Modal --}}
        <div class="modal fade " id="delete-student-modal">
            <div class="modal-dialog small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form id="delete-students-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">
                                Yes, Delete
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

            // Sweet Alert Declaration
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 6000
            });

            // Delete Board
            var deleteId;
            $(document).on("click", ".delete-btn", function () {
                deleteId = $(this).data('id');
                let url = "{{ route('students.destroy', ':id') }}";
                url = url.replace(':id', deleteId);
                $("#delete-students-form").attr("action", url);
            });

        });
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#students-table').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
@endpush