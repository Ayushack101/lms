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
                        <h1>Boards</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Boards</li>
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
                                <h3 class="card-title">All Boards</h3>
                                <div class="d-flex">
                                    <form action="{{ route('boards.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search board..." value="{{ request('search') }}">

                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <a class="ml-3" href="{{ route('boards.create') }}"><button type="button"
                                            class='btn btn-success'><i class="fas fa-plus"></i>
                                            Add Board</button></a>
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
                                <table id="bosard-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Board Name</th>
                                            <th>Create At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="board">
                                        @foreach ($boards as $board)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $board->board_name }}</td>
                                                <td>{{ $board->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('boards.edit', $board->id) }}"><button type="button"
                                                            class='btn btn-primary edit-btn'> <i
                                                                class="fas fa-edit"></i></button></a>

                                                    <button type="button" data-toggle="modal" data-target="#delete-board-modal"
                                                        data-id="{{ $board->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $boards->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete Board Modal --}}
        <div class="modal fade " id="delete-board-modal">
            <div class="modal-dialog small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form id="delete-board-form" method="POST">
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

            // Add Board
            $("#add-board").on("submit", function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $(".text-danger").text("");
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    url: "{{ route('boards.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function () {
                        $(".save").prop("disabled", true);
                        $(".save").text("Saving...");
                    },
                    complete: function () {
                        $(".save").prop("disabled", false);
                        $(".save").text("Save");
                    },
                    success: function (resp, textStatus, xhr) {
                        if (xhr.status === 201 || xhr.status === 200) {
                            $("#add-board-modal").modal("hide");
                            Toast.fire({
                                icon: 'success',
                                title: resp?.message
                            })
                            showUpdatedBoard(); // Refresh the Boards
                            $("#add-board")[0].reset(); // Reset the Form
                        }
                        console.log(resp?.message);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        if (xhr.status === 422) {
                            // Validation error
                            printValidationErrorMsg(xhr.responseJSON.errors);
                        } else {
                            $("#add-board-modal").modal("hide");
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message ||
                                    "An unexpected error occurred."
                            })
                        }
                    },
                });

                function printValidationErrorMsg(msg) {
                    $.each(msg, function (field_name, error) {
                        $(document)
                            .find("#" + field_name + "_error").text(error[0]);
                        $(document).find('#' + field_name).addClass('is-invalid');
                    });
                }
            });

            // Updated Board
            function showUpdatedBoard() {
                let table = $('#board-table').DataTable();
                table.destroy(); // destroy old DataTable before replacing DOM

                $.ajax({
                    url: '{{ route('boards.index') }}',
                    type: 'GET',
                    success: function (resp) {
                        $('#board').html(resp);

                        // Reinitialize DataTable
                        $('#board-table').DataTable({
                            paging: true,
                            lengthChange: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            autoWidth: false,
                            responsive: true
                        });
                    }
                });
            }

            // Delete Board
            var deleteId;
            $(document).on("click", ".delete-btn", function () {
                deleteId = $(this).data('id');
                let url = "{{ route('boards.destroy', ':id') }}";
                url = url.replace(':id', deleteId);
                $("#delete-board-form").attr("action", url);
            });

            $("#delete-board").on("click", function (e) {
                if (deleteId) {
                    var url = "{{ route('boards.destroy', 'deleteId') }}",
                        url = url.replace('deleteId', deleteId);
                    $.ajax({
                        url: url,
                        type: "POST",
                        contentType: false,
                        processData: false,
                        cache: false,
                        beforeSend: function () {
                            $("#delete-board").prop("disabled", true);
                        },
                        complete: function () {
                            $("#delete-board").prop("disabled", false);
                        },
                        success: function (resp, textStatus, xhr) {
                            if (xhr.status === 201 || xhr.status === 200) {
                                $("#delete-board-modal").modal("hide");
                                Toast.fire({
                                    icon: 'success',
                                    title: resp.message
                                })
                                showUpdatedBoard(); // Refresh the Boards
                            }
                        },
                        error: function (xhr, status, error) {
                            $("#delete-board-modal").modal("hide");
                            Toast.fire({
                                icon: 'error',
                                title: xhr.responseJSON.message ||
                                    "An unexpected error occurred."
                            })
                        },
                    });
                }
            })
        });
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#board-table').DataTable({
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