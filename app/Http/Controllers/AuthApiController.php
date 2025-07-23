<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RoleService;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        try {
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
        } catch (Exception $ex) {
            Log('error', $ex->getMessage());
        }
    }
}
