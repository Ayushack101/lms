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
                        <h1>Subjects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subjects</li>
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
                                <h3 class="card-title">All Subjects</h3>
                                <div class="d-flex">
                                    <form action="{{ route('subjects.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search subject..." value="{{ request('search') }}">

                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <a class="ml-3" href="{{ route('subjects.create') }}"><button type="button"
                                            class='btn btn-success'><i class="fas fa-plus"></i>
                                            Add Subject</button></a>
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
                                <table id="subjects-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>
                                            <th>Board</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subject">
                                        @foreach ($subjects as $subject)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $subject->subject_name }}</td>
                                                <td>{{ $subject->subject_code }}</td>
                                                <td>{{ $subject->board ? $subject->board->board_name : 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('subjects.edit', $subject->id) }}"><button type="button"
                                                            class='btn btn-primary edit-btn'> <i
                                                                class="fas fa-edit"></i></button></a>

                                                    <button type="button" data-toggle="modal" data-target="#delete-subject-modal"
                                                        data-id="{{ $subject->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $subjects->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete Subject Modal --}}
        <div class="modal fade " id="delete-subject-modal">
            <div class="modal-dialog small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Subject</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form id="delete-subject-form" method="POST">
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
                let url = "{{ route('subjects.destroy', ':id') }}";
                url = url.replace(':id', deleteId);
                $("#delete-subject-form").attr("action", url);
            });

        });
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush