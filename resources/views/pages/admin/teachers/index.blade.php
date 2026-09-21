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
                        <h1>Teachers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Teachers</li>
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
                                <h3 class="card-title">All Teachers</h3>
                                <div class="d-flex">
                                    <form action="{{ route('teachers.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search teacher..." value="{{ request('search') }}">

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
                                <table id="teachers-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Teacher Name</th>
                                            <th>Teacher Code</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>School Name</th>
                                            <th>School Address</th>
                                            <th>Personal Address</th>
                                            <th>Principle Name</th>
                                            <th>DOB</th>
                                            <th>Session Start</th>
                                            <th>Representative Name</th>
                                            <th>Representative Contact</th>
                                            <th>Status</th>
                                            <th>Board</th>
                                            <th>Classes</th>
                                            <th>Subjects</th>
                                            <th>Books</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="teacher">
                                        @foreach ($teachers as $teacher)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $teacher->teacher_name }}</td>
                                                <td>{{ $teacher->teacher_code }}</td>
                                                <td>{{ $teacher->teacher_mobile }}</td>
                                                <td>{{ $teacher->user->email ?? '' }}</td>
                                                <td>{{ $teacher->school_name }}</td>
                                                <td>{{ $teacher->school_address }}</td>
                                                <td>{{ $teacher->personal_address }}</td>
                                                <td>{{ $teacher->principal_name }}</td>
                                                <td>{{ $teacher->dob }}</td>
                                                <td>{{ $teacher->session_start }}</td>
                                                <td>{{ $teacher->representative_name }}</td>
                                                <td>{{ $teacher->representative_contact }}</td>
                                                <td> <p class="badge text-white" style="background-color: {{ $teacher->status == 'active' ? 'green' : 'red' }};">{{ $teacher->status }}</p> </td>
                                                <td>{{ $teacher->board->board_name ?? '' }}</td>
                                                <td>{{ $teacher->classes->pluck('class_name')->implode(', ') ?? '' }}</td>  
                                                <td>{{ $teacher->subjects->pluck('subject_name')->implode(', ') ?? '' }}</td>
                                                <td>{{ $teacher->books->pluck('book_name')->implode(', ') ?? '' }}</td>

                                                <td>
                                                    <a href="{{ route('teachers.edit', $teacher->id) }}"><button type="button"
                                                            class='btn btn-primary edit-btn'> <i
                                                                class="fas fa-edit"></i></button></a>

                                                    <button type="button" data-toggle="modal" data-target="#delete-teacher-modal"
                                                        data-id="{{ $teacher->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $teachers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete Teacher Modal --}}
        <div class="modal fade " id="delete-teacher-modal">
            <div class="modal-dialog small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Teacher</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form id="delete-teacher-form" method="POST">
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
                let url = "{{ route('teachers.destroy', ':id') }}";
                url = url.replace(':id', deleteId);
                $("#delete-teacher-form").attr("action", url);
            });

        });
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#teachers-table').DataTable({
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