<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RefreshToken;
use App\Services\RoleService;
use App\Services\Service;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
            if ($user->force_logout) {
                $user->force_logout = false;
                $user->save();
            }

            if ($user->allow_access && Auth::attempt($credentials)) {
                // Generate access token
                $accessToken = $user->createToken('auth_token')->plainTextToken;

                // Generate refresh token
                $refreshTokenString = Str::random(64);
                RefreshToken::create([
                    'user_id' => $user->id,
                    'token' => hash('sha256', $refreshTokenString),
                    'expires_at' => Carbon::now()->addDays(14),
                    'revoked' => false,
                ]);

                return response()->json([
                    'message' => Service::welcomeMessage(),
                    'token' => $accessToken,
                    'refresh_token' => $refreshTokenString,
                    'user' => $user,
                ], 200);
            }

            if (!$user->allow_access) {
                return response()->json([
                    'message' => Service::waitForActivateMessage(),
                ], 400);
            }
        }

        return response()->json([
            'message' => Service::userNotFound(),
        ], 404);
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

        // If user is auto-approved, issue tokens
        if ($user->allow_access) {
            $accessToken = $user->createToken('auth_token')->plainTextToken;
            $refreshTokenString = Str::random(64);
            RefreshToken::create([
                'user_id' => $user->id,
                'token' => hash('sha256', $refreshTokenString),
                'expires_at' => Carbon::now()->addDays(14),
                'revoked' => false,
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'token' => $accessToken,
                'refresh_token' => $refreshTokenString,
                'user' => $user
            ], 200);
        }

        // Otherwise, no token issued
        return response()->json([
            'message' => 'User registered successfully, awaiting account activation',
            'token' => '',
            'refresh_token' => '',
            'user' => $user
        ], 200);
    }


    public function logout(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'refresh_token' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => Service::userNotFound(),
            ], 404);
        }

        // Revoke access tokens
        $user->tokens()->delete();

        // Revoke refresh token
        $hashedToken = hash('sha256', $request->refresh_token);
        RefreshToken::where('user_id', $user->id)
            ->where('token', $hashedToken)
            ->update(['revoked' => true]);

        // Set force logout flag
        $user->force_logout = true;
        $user->save();

        return response()->json([
            'message' => 'You are logged out.',
            'user' => $user,
            'token' => null
        ], 200);
    }


    public function checkSession(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'logout' => true,
                'message' => 'Session invalid or expired.'
            ], 401);
        }

        if ($user->force_logout) {
            $user->tokens()->delete();
            return response()->json([
                'logout' => true,
                'message' => Service::sessionExpiredOrForceLogout()
            ], 401);
        }

        return response()->json([
            'logout' => false,
            'user' => $user,
            'message' => 'Session valid',
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $hashedToken = hash('sha256', $request->refresh_token);
        $token = RefreshToken::where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->where('revoked', false)
            ->first();

        if (!$token) {
            return response()->json(['message' => 'Invalid or expired refresh token'], 401);
        }

        $user = $token->user;
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        // Optionally, rotate refresh token for extra security
        $newRefreshTokenString = Str::random(64);
        $token->update([
            'token' => hash('sha256', $newRefreshTokenString),
            'expires_at' => now()->addDays(14),
        ]);

        return response()->json([
            'token' => $accessToken,
            'refresh_token' => $newRefreshTokenString,
            'user' => $user,
        ]);
    }
}
