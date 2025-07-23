<?php

namespace App\Services;

use App\Models\User;
use Exception;
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
      $user->save();
    }

    public function updateInfo(array $data, $user) {
      try {
        $user->update($data);
        return true;
        
      } catch (Exception $ex) {
        \Log($ex->getMessage());
        return false;
      }

    }

    public function updatePassword(string $current_password, string $new_password, $user) {
      if (!SecurityService::validatePassword($current_password, $user->password)) {
        return back()->withErrors([
          'message' => 'Current password is incorrect!',
          'status' => 400
        ]);
      }
      $user->password = Hash::make($new_password);
      $user->force_logout = Service::true();
      $user->save();
      return true;
    }
}
