<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->force_logout == true) {
            $user->force_logout = false;
            $user->save();
        }

        if ($user->allow_access == true && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with([
                'message' => Service::welcomeMessage(),
            ]);
        }

        if (!$user->allow_access) {
            return back()->with([
                "message" => Service::waitForActivateMessage(),
                'audio' => Service::warningAudio(),
                'status_code' => 201,
            ]);
        }
        return back()->withErrors(['email' => Service::invalidCredentialMessage()])->onlyInput('email');
    }

    public function showRegister()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
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
        $user->force_logout = false;
        $user->save();
        return redirect('/login')->with('message', Service::accountCreatedMessage());
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->force_logout = true;
        $user->save();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', Service::logoutMessage());
    }
}
