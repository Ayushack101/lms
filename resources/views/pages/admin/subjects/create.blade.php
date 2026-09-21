@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Subjects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                            <li class="breadcrumb-item active">Create Subject</li>
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
                        <h3 class="card-title">Create Subject</h3>
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
                        <form action="{{ route('subjects.store') }}" method="POST">
                            @csrf
                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Board *</label>
                                    <select name="board_id" class="form-control">
                                        <option value="">Select Board</option>
                                        @foreach ($boards as $board)
                                            <option value="{{ $board->id }}" {{ old('board_id') == $board->id ? 'selected' : '' }}>
                                                {{ $board->board_name }}    
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('board_id') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Subject Name *</label>
                                    <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name') }}">
                                    <span class="text-danger">@error('subject_name') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{-- Row 2 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Subject Code *</label>
                                    <input type="text" name="subject_code" class="form-control"
                                        value="{{ old('subject_code') }}">
                                    <span class="text-danger">@error('subject_code') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Create Subject
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