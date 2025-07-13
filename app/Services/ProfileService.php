<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{

    public function uploadProfile(array $data) {
      $user = Auth::user();
      if ($user->profile_picture) {
        Storage::disk('public')->delete($user->profile_picture);
      }
      $user->profile_picture = $data['profile_photo']->store('profiles','public');
      return $user->save();
    }

    public function updateInfo(array $data, $user) {
      $user->update($data);
      return $user;
    }

    public function validatePassword(string $password, string $user_password) {
      if (!Hash::check($password, $user_password)) {
       return false; 
      }
      return true;
    }

    public function updatePassword(string $current_password, string $new_password, $user) {
      if (!$this->validatePassword($current_password, $user->password)) {
        return back()->with(['message' => 'Current password is incorrect!', 'status' => 400]);
      }
      $user->password = Hash::make($new_password);
      $user->force_logout = ForceLogoutService::forceLogout();
      $user->save();
      return true;
    }
}
