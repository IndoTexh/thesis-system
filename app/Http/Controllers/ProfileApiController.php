<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        $user->save();
        return response()->json([
            'message' => 'User profile uploaded successfully.',
            'user' => $user,
        ], 200);
    }

    public function updateInfo(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->user_id,
                'user_id' => 'required|integer|exists:users,id',
            ]);
            
            $user = User::where('id', $request->user_id)->first();
            if ($user) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();
                return response()->json([
                    'message' => Service::updateCredentialMessage(),
                    'user' => $user,
                ], 200);
            }
            return response()->json([
                'message' => Service::userNotFound(),
                'user' => null,
            ], 404);
        } catch (\Exception $e) {
            Log::error('Update profile info error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update profile information: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function updatePass(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required|string|min:6',
                'new_password' => 'required|string|min:6',
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $user = User::where('id', $request->user_id)->first();
            
            if (!$user) {
                return response()->json([
                    'message' => Service::userNotFound(),
                    'user' => null,
                ], 404);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'message' => 'Current password is incorrect.',
                    'user' => null,
                ], 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->force_logout = true;
            $user->tokens()->delete();
            $user->save();
            
            return response()->json([
                'message' => Service::updatePasswordMessage(),
                'user' => $user,
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update password error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update password: ' . $e->getMessage(),
            ], 400);
        }
    }
}
