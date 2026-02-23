<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            if (auth()->user()->role === 'teacher') {
                return redirect('/teacher/dashboard');
            }
            
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:student,teacher'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Redirect based on user role
        if ($user->role === 'teacher') {
            return redirect('/teacher/dashboard');
        }

        return redirect('/dashboard');
    }

    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/');
    // }
    public function logout()
{
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
}

}
