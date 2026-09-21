@extends('layouts.login')
@section('LoginContent')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>LMS</b>Admin</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0" style="list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" action="{{ route('login.submit') }}">
                    @csrf
                    @method('POST')
                    <input type="text" class="form-control" name="role" value="admin" hidden>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center mt-2 mb-3">
                                                                                <a href="#" class="btn btn-block btn-primary">
                                                                                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                                                                                </a>
                                                                                <a href="#" class="btn btn-block btn-danger">
                                                                                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                                                                </a>
                                                                            </div> -->
                <!-- /.social-auth-links -->

                <!-- <p class="mb-1">
                                                                                <a href="forgot-password.html">I forgot my password</a>
                                                                            </p>
                                                                            <p class="mb-0">
                                                                                <a href="register.html" class="text-center">Register a new membership</a>
                                                                            </p> -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

@endsection