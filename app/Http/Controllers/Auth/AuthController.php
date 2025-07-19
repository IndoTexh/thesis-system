<?php

namespace App\Http\Controllers\Auth;

use App\Services\ForceLogoutService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function showLogin() {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->force_logout == ForceLogoutService::true()) {
            $user->force_logout = ForceLogoutService::false();
            $user->save();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('message', 'Welcome');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    public function showRegister() {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:student,supervisor'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->force_logout = ForceLogoutService::false();
        $user->save();
        return redirect('/login')->with('message', 'Account created! Please log in.');
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->force_logout = ForceLogoutService::true();
        $user->save();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', "Your're logged out!");
    } 
}
