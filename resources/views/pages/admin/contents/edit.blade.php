@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Content</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('contents.index') }}">Content</a></li>
                            <li class="breadcrumb-item active">Edit Content</li>
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
                        <h3 class="card-title">Edit Content</h3>
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
                        <form action="{{ route('contents.update', $content->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Row 1 --}}
                            <div class="row">
                                {{-- <div class="col-md-6 mb-3">
                                    <label>Content Name *</label>
                                    <input type="text" name="content_name" class="form-control"
                                        value="{{ old('content_name', $content->content_name) }}">
                                    <span class="text-danger">@error('content_name') {{ $message }} @enderror</span>
                                </div> --}}
                                <div class="col-md-6 mb-3">
                                    <label>Allow *</label>
                                    <select class="form-control" id="allow" name="allow">
                                        <option value="" selected disabled>Select an option</option>
                                        <option value="teacher" {{ old('allow', $content->allow) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                        <option value="student" {{ old('allow', $content->allow) == 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="both" {{ old('allow', $content->allow) == 'both' ? 'selected' : '' }}>
                                            Both</option>
                                        <option value="demo" {{ old('allow', $content->allow) == 'demo' ? 'selected' : '' }}>
                                            Demo</option>
                                    </select>
                                    <span class="text-danger">@error('allow') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Update Content
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