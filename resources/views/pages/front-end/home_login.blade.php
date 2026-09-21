@extends('layouts.frontend_login')

@section('homeContent')
    <!-- floating education icons -->
    <div class="floating-icon">🎓</div>
    <div class="floating-icon">📘</div>
    <div class="floating-icon">🧪</div>
    <div class="floating-icon">📚</div>

    <!-- full-width logo strip on top, not a header -->
    <div class="page-banner">
        <img src="{{ asset('build/assets/img/logo.png') }}" alt="Ak Tech solution"
            style="border-radius: 18px 2px;; margin:10px;padding:10px" />
        <span>
            <h1 style="color: white; ">Web Support</h1>
        </span>
    </div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- LEFT SIDE (image + tutorial) -->
            <div class="auth-left">
                <img src="{{ asset('build/assets/img/form.png') }}" alt="Learning Astronaut" />
                <h2>Interactive Learning Experience</h2>
                <p>Watch a short tutorial to understand how to use The computer Minds LMS efficiently.</p>
            </div>

            <!-- RIGHT SIDE (logo + form + buttons) -->
            <div class="auth-right">
                {{-- <a href="#" class="return-main">
                    <span class="icon">⌂</span>
                    <span>Return to Main Site</span>
                </a> --}}

                <div class="auth-logo">
                    <img src="{{ asset('build/assets/img/logo.png') }}" alt="Ak tech solutions" />
                </div>

                <div class="welcome-text">
                    <small>Welcome to</small>
                    <h3>One-Stop Platform</h3>
                </div>

                {{-- GLOBAL ERROR --}}
                @if ($errors->any())
                    <div style="color: red; font-weight: 600;" class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('home.login.submit') }}" method="post">
                    @csrf
                    <div class="input-with-icon">
                        <div class="icon-box">&#9993;</div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="cbse@demo.in" required />
                    </div>

                    <div class="input-with-icon">
                        <div class="icon-box">&#128274;</div>
                        <input type="password" id="password" name="password" placeholder="••••••••••••" required />
                    </div>

                    <!-- SHOW PASSWORD -->
                    <label class="show-pass">
                        <input type="checkbox" onclick="togglePassword()" /> Show Password
                    </label>

                    <div class="actions-row">
                        <button type="submit" class="btn-login">LOGIN &gt;</button>
                        {{-- <a href="#" class="forgot-link">Forgot Password</a> --}}
                    </div>

                    <!-- REGISTRATION -->
                    <div class="reg-buttons">
                        <a href="{{ route('home.teacher.registration') }}" class="btn-reg teacher">
                            Teacher Registration
                        </a>
                        <a href="{{ route('home.student.registration') }}" class="btn-reg student">
                            Student Registration
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} AK Tech Solutions. All rights reserved.
    </div>

@endsection

@push('scripts')
    <script>
        function togglePassword() {
            let pass = document.getElementById("password");
            pass.type = pass.type === "password" ? "text" : "password";
        }
    </script>
@endpush