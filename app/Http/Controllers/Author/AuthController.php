<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('author.auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email обязателен',
            'email.email' => 'Email должен быть корректным',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
        ]);

        // Attempt to authenticate user
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $request->session()->regenerate();
            return redirect()->route('author.dashboard')->with('success', 'Вы успешно вошли в аккаунт');
        }

        return back()->withErrors([
            'email' => 'Учетные данные не совпадают с нашими записями.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('author.auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ], [
            'first_name.required' => 'Имя обязательно',
            'last_name.required' => 'Фамилия обязательна',
            'email.required' => 'Email обязателен',
            'email.email' => 'Email должен быть корректным',
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'terms.accepted' => 'Вы должны согласиться с условиями использования',
        ]);

        // Create User in users table
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
        ]);

        // Create Author profile in authors table
        Author::create([
            'user_id' => $user->id,
            'display_name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'slug' => Str::slug($validated['first_name'] . ' ' . $validated['last_name'] . '-' . $user->id),
            'is_active' => true,
            'is_verified' => false,
        ]);

        return redirect()->route('author.auth.login')
                       ->with('success', 'Регистрация прошла успешно. Пожалуйста, войдите в аккаунт.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Вы успешно вышли из аккаунта');
    }
}
