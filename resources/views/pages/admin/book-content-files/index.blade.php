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
                        <h1>{{ $content->content_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $content->content_name }}</li>
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
                                <h3 class="card-title">All {{ $content->content_name }}</h3>
                                <div class="d-flex">
                                    <form action="{{ route('books.content.file.index', $content->id) }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search file..." value="{{ request('search') }}">

                                            <button class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <a class="ml-3" href="{{ route('books.content.file.create', $content->id) }}"><button type="button"
                                            class='btn btn-success'><i class="fas fa-plus"></i>
                                            Add {{ $content->content_name }}</button></a>
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
                                <table id="book-content-file-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject </th>
                                            <th>Class</th>
                                            <th>Book </th>
                                            <th>Title</th>
                                            <th>File</th>
                                            <th>Thumbnail</th>
                                            <th>Create At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="book-content-file">
                                        @foreach ($bookContentFiles as $file)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $file->book->subject->subject_name ?? '-' }}</td>
                                                <td>{{ $file->book->class->class_name ?? '-' }}</td>
                                                <td>{{ $file->book->book_name ?? '-' }}</td>
                                                <td>{{ $file->title }}</td>
                                                <td>
                                                @if ($file->content->content_name == 'E-book' || $file->content->content_name == 'Test Paper Generator')
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $file->extract_path) . '/' . $file->entry_file }}" target="_blank"> <i class="fas fa-eye"></i> </a>

                                                @elseif ($file->content->content_name == 'Software Download Link')
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                        <i class="fas fa-download"></i>
                                                    </a>

                                                @elseif ($file->content->content_name == 'Topic Animation')
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @elseif ($file->content->content_name == 'Topic Animation')
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else 
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                                </td>
                                                <td><img src="{{ asset('storage/' . $file->thumbnail) }}" width="100" /></td>
                                                <td>{{ $file->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('books.content.file.edit', $file->id) }}"><button type="button" class='btn btn-primary edit-btn'>
                                                            <i class="fas fa-edit"></i></button></a>

                                                    <button type="button" data-toggle="modal"
                                                        data-target="#delete-book-file-content-modal"
                                                        data-id="{{ $file->id }}" class='btn btn-danger mx-2 delete-btn'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-end">
                                    {{ $bookContentFiles->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete Book File Content Modal --}}
        <div class="modal fade " id="delete-book-file-content-modal">
            <div class="modal-dialog small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete File</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form id="delete-book-file-content-form" method="POST">
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
                let url = "{{ route('books.content.file.destroy', ':id') }}";
                url = url.replace(':id', deleteId);
                $("#delete-book-file-content-form").attr("action", url);
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