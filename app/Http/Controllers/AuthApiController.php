<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RoleService;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->force_logout == true) {
                $user->force_logout = false;
                $user->save();
            }
            if ($user->allow_access == true && Auth::attempt($credentials)) {
                return response()->json([
                    'message' => Service::welcomeMessage(),
                    'token' => $user->createToken('auth_token')->plainTextToken,
                ], 200);
            }
            if (!$user->allow_access) {
                return response()->json([
                    'message' => Service::waitForActivateMessage(),
                ], 200);
            }
        }
        return response()->json([
            'message' => Service::userNotFound(),
        ], 400);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:student,supervisor'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'allow_access' => in_array($request->role, [RoleService::admin(), RoleService::supervisor()]) ? false : true,
            'force_logout' => false,
        ]);
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user
        ], 200);
    }
}
