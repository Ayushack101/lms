@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit {{ $content->content_name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('books.content.file.index', $content->id) }}">{{ $content->content_name }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit {{ $content->content_name }}</li>
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
                        <h3 class="card-title">Create {{ $content->content_name }}</h3>
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
                        <form action="{{ route('books.content.file.update', $bookContentFile->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input hidden type="text" name="content_id" value="{{ $content->id }}">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Board *</label>
                                    <select id="board_id" name="board_id" class="form-control">
                                        <option value="">Select Board</option>
                                        @foreach ($boards as $board)
                                            <option value="{{ $board->id }}" {{ old('board_id', $bookContentFile->book->subject->board_id) == $board->id ? 'selected' : '' }}>
                                                {{ $board->board_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('board_id') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Subject *</label>
                                    <select id="subject_id" name="subject_id" class="form-control">
                                        <option value="">Select Subject</option>
                                        <option value="{{ $bookContentFile->book->subject_id }}" selected>
                                            {{ $bookContentFile->book->subject->subject_name }}
                                        </option>
                                    </select>
                                    <span class="text-danger">@error('subject_id') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Book *</label>
                                    <select id="book_id" name="book_id" class="form-control">
                                        <option value="">Select Book</option>
                                        <option value="{{ $bookContentFile->book->id }}" selected>
                                            {{ $bookContentFile->book->book_name }}
                                        </option>
                                    </select>
                                    <span class="text-danger">@error('book_id') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Title *</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $bookContentFile->title) }}">
                                    <span class="text-danger">@error('title') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Thumbnail *</label>
                                    <input type="file" name="thumbnail" class="form-control">
                                    <img class="mt-2" src="{{ asset('storage/' . $bookContentFile->thumbnail) }}"
                                        width="200" />
                                    <span class="text-danger">@error('thumbnail') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Description *</label>
                                    <input type="text" name="description" class="form-control"
                                        value="{{ old('description', $bookContentFile->description) }}">
                                    <span class="text-danger">@error('description') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            @if($content->content_name == 'E-book')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>File Path *</label>
                                        <input type="text" name="file_path" class="form-control"
                                            placeholder="zips/ebooks/AI_1.0/Class1/AI_1.0_Ebook_1.zip"
                                            value="{{ old('file_path', $bookContentFile->file_path) }}">
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Extracted Folder Path *</label>
                                        <input type="text" name="extract_path" class="form-control"
                                            placeholder="contents/ebooks/AI_1.0/Class1/AI_1.0_Ebook_1"
                                            value="{{ old('extract_path', $bookContentFile->extract_path) }}">
                                        <span class="text-danger">@error('extract_path') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                            @elseif($content->content_name == 'Test Paper Generator')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>File Path *</label>
                                        <input type="text" name="file_path" class="form-control"
                                            placeholder="zips/tpg/AI_1.0/Class1/AI_1.0_tpg_1.zip"
                                            value="{{ old('file_path', $bookContentFile->file_path) }}">
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Extracted Folder Path *</label>
                                        <input type="text" name="extract_path" class="form-control"
                                            placeholder="contents/tpg/AI_1.0/Class1/AI_1.0_tpg_1"
                                            value="{{ old('extract_path', $bookContentFile->extract_path) }}">
                                        <span class="text-danger">@error('extract_path') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                            @elseif($content->content_name == 'Software Download Link')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Software Download Link *</label>
                                        <input type="text" name="file_path" class="form-control"
                                            placeholder="zips/sdl/AI_1.0/Class1/AI_1.0_sdl.zip"
                                            value="{{ old('file_path', $bookContentFile->file_path) }}">
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                            @elseif($content->content_name == 'Topic Animation')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>File Path *</label>
                                        <input type="text" name="file_path" class="form-control"
                                            placeholder="videos/AI_1.0/Class1/AI_1.0_topic_animation.mp4"
                                            value="{{ old('file_path', $bookContentFile->file_path) }}">
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                </div>

                            @else
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <button type="button" id="toggleInputBtn" class="btn btn-primary btn-sm"
                                            data-mode="text">
                                            📁 Switch to File Upload
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3 toggle-container" id="textInputContainer">
                                        <label>File Path *</label>
                                        <input type="text" name="file_path_text" class="form-control"
                                            placeholder="pdfs/content_name/AI_1.0/Class1/AI_1.0_answer_key.pdf"
                                            value="{{ old('file_path_text', $bookContentFile->file_path) }}">
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                    <div class="col-md-6 mb-3 toggle-container" id="fileInputContainer" style="display: none;">
                                        <label>Upload {{ $content->content_name }} *</label>
                                        <input type="file" name="file_path" class="form-control">
                                        <img class="mt-2" src="{{ asset('storage/' . $bookContentFile->file_path) }}"
                                            width="200" />
                                        <span class="text-danger">@error('file_path') {{ $message }} @enderror</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Update {{ $content->content_name }}
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

            $('#toggleInputBtn').on('click', function () {
                const $btn = $(this);
                const currentMode = $btn.data('mode');

                if (currentMode === 'text') {
                    $('#textInputContainer').hide().find('input').prop('disabled', true);
                    $('#fileInputContainer').show().find('input').prop('disabled', false);

                    $btn.html('✏️ Switch to File Path Text').data('mode', 'file');
                } else {
                    $('#fileInputContainer').hide().find('input').prop('disabled', true);
                    $('#textInputContainer').show().find('input').prop('disabled', false);

                    $btn.html('📁 Switch to File Upload').data('mode', 'text');
                }
            });

            // Board change -> reload subjects
            $('#board_id').on('change', function () {
                let boardId = $(this).val();

                if (!boardId) {
                    alert("Please select board first");
                    return;
                }

                $('#subject_id').html('<option value="">Loading...</option>');
                $('#book_id').html('<option value="">Select Book</option>');

                $.ajax({
                    url: '/admin/get-subjects-by-board/' + boardId,
                    type: 'GET',
                    success: function (response) {
                        let subjects = response?.subjects || [];
                        let subjectOptions = '<option value="">Select Subject</option>';

                        $.each(subjects, function (i, subject) {
                            subjectOptions += `<option value="${subject.id}">${subject.subject_name}</option>`;
                        });

                        $('#subject_id').html(subjectOptions);
                        $('#book_id').html('<option value="">Select Book</option>');
                    }
                });
            });

            // Subject change -> reload books
            $('#subject_id').on('change', function () {
                let subjectId = $(this).val();

                if (!subjectId) {
                    alert("Please select subject first");
                    return;
                }

                $('#book_id').html('<option value="">Loading...</option>');

                $.ajax({
                    url: '/admin/get-books-by-subject/' + subjectId,
                    type: 'GET',
                    success: function (response) {
                        let books = response?.books || [];
                        let bookOptions = '<option value="">Select Book</option>';

                        $.each(books, function (i, book) {
                            bookOptions += `<option value="${book.id}">${book.book_name}</option>`;
                        });

                        $('#book_id').html(bookOptions);
                    }
                });
            });
        });
    </script>
@endpush
