@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create New Content</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('contents.index') }}">Content</a></li>
                            <li class="breadcrumb-item active">Create Content</li>
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
                        <h3 class="card-title">Create Content</h3>
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
                        <form action="{{ route('contents.store') }}" method="POST">
                            @csrf
                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Content Name *</label>
                                    <input type="text" name="content_name" class="form-control"
                                        value="{{ old('content_name') }}">
                                    <span class="text-danger">@error('content_name') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Allow *</label>
                                    <select class="form-control" id="allow" name="allow">
                                        <option value="" selected disabled>Select an option</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="student">Student</option>
                                        <option value="both">Both</option>
                                        <option value="demo">Demo</option>
                                    </select>
                                    <span class="text-danger">@error('allow') {{ $message }} @enderror</span>
                                </div>
                            </div>
                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Create Content
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