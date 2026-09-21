@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Class</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Class</a></li>
                            <li class="breadcrumb-item active">Edit Class</li>
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
                        <h3 class="card-title">Edit Class</h3>
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
                        <form action="{{ route('classes.update', $class->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Row 1 --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Class Name *</label>
                                    <input type="text" name="class_name" class="form-control"
                                        value="{{ old('class_name', $class->class_name) }}">
                                    <span class="text-danger">@error('class_name') {{ $message }} @enderror</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Class Position *</label>
                                    <input type="text" name="class_position" class="form-control"
                                        value="{{ old('class_position', $class->class_position) }}">
                                    <span class="text-danger">@error('class_position') {{ $message }} @enderror</span>
                                </div>
                            </div>

                            {{-- Button --}}
                            <button type="submit" class="btn btn-success">
                                Update Class
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