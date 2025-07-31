<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
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
            'user' => $user,
        ], 404);
    }

    public function updatePass(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if ($user && Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->force_logout = true;
            $user->tokens->delete();
            $user->save();
            return response()->json([
                'message' => Service::updatePasswordMessage(),
                'user' => $user,
            ], 200);
        }
        return response()->json([
            'message' => Service::userNotFound(),
            'user' => $user,
        ], 404);
    }
}
