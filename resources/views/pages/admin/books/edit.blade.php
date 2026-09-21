@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Book</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></li>
                            <li class="breadcrumb-item active">Edit Book</li>
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
                        <h3 class="card-title">Edit Book</h3>
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
                        <form action="{{ route('books.update', $book->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Select Subject *</label>
                                    <select class="form-control" name="subject_id">
                                        <option value="" selected disabled>Select an option</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id', $book->subject_id) == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->subject_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('subject_id') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Book Name *</label>
                                    <input type="text" name="book_name" class="form-control"
                                        value="{{ old('book_name', $book->book_name) }}">
                                    <span class="text-danger">@error('book_name') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Select Class *</label>
                                    <select class="form-control" name="class_id">
                                        <option value="" selected disabled>Select an option</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id', $book->class_id) == $class->id ? 'selected' : '' }}>{{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('class_id') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Select Content *</label>
                                    @php
                                        $selectedContents = old('content_id', $book->contents->pluck('id')->toArray());
                                    @endphp
                                    <select class="select2bs4" multiple="multiple" name="content_id[]"
                                        data-placeholder="Select Content" style="width: 100%;">
                                        @foreach ($contents as $content)
                                            <option value="{{ $content->id }}" {{ in_array($content->id, $selectedContents) ? 'selected' : '' }}>
                                                {{ $content->content_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('content_id') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Update Book
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
    </script>
@endpush