<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::lower($request->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'username' => "Demasiados intentos. Intenta nuevamente en {$seconds} segundos.",
            ]);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('usuario.perfil');
        }

        RateLimiter::hit($throttleKey, 60);

        throw ValidationException::withMessages([
            'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}