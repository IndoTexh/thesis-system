<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\SecurityService;
use App\Services\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }

    public function index() {
        return Inertia::render('Student/Profile');
    }

    public function upload() {
        return Inertia::render('Student/Upload');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'profile_photo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);
        $this->profileService->uploadProfile($validated);
        return back()->with('message', 'Profile photo uploaded successfully!');
    }

    public function updateInfo(Request $request) {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
        ]);
        if($this->profileService->updateInfo($validated, $user)) {
            return back()->with([
                'message' => 'profile updated successfully!',
                'status' => 200,
                'audio' => Service::successAudio()
            ]);
        }
        return back()->with([
            'message' => 'An error occurred',
            'status' => 500,
            'audio' => Service::warningAudio()
        ]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);
        $this->profileService->updatePassword($request->current_password, $request->new_password, $request->user());
    }    
}
