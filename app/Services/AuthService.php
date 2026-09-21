<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'credentials' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return 'admin.dashboard';
        } else {
            return 'demo.dashboard';
        }
    }
    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function apiLogin(array $credentials): array
    {
        if (!$credentials['role']) {
            throw ValidationException::withMessages([
                'credentials' => ['The role field is required.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'credentials' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->role === 'admin') {
            throw ValidationException::withMessages([
                'credentials' => ['You are not authorized to access this resource.'],
            ]);
        }

        $user_details = '';
        if ($credentials['role'] === 'teacher' && $user->role === 'teacher') {
            $user_details = Teacher::where('user_id', $user->id)->first();
        } elseif ($credentials['role'] === 'student' && $user->role === 'student') {
            $user_details = Student::with(['class', 'section', 'teacher'])->where('user_id', $user->id)->firstOrFail();
        } else {
            throw ValidationException::withMessages([
                'credentials' => ['You are not authorized to access this resource.'],
            ]);
        }

        return [
            'access_token' => $user->createToken($user->role . '-api')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'user_details' => $user_details
        ];
    }
}
