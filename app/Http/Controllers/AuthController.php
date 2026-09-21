<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function showLoginForm(): View
    {
        return view('pages.login');
    }
    public function login(LoginRequest $request): RedirectResponse
    {
        $redirect = $this->authService->login($request->validated());

        $request->session()->regenerate();

        return redirect()->route($redirect);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout($request);

        return redirect()->route('login');
    }

    // API Methods

    public function apiLogin(LoginRequest $request): JsonResponse
    {
        $authentication = $this->authService->apiLogin($request->validated());

        return response()->json([
            'message' => 'Login successful',
            ...$authentication,
        ]);
    }

    public function apiLogout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
