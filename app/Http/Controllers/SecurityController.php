<?php

namespace App\Http\Controllers;

use App\Services\SecurityService;
use App\Services\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SecurityController extends Controller
{

    public function confirmView() {
        return Inertia::render('Student/ConfirmPass');
    }

    public function validatePassword(Request $request) {
        if($request->password) {
            if (!SecurityService::validatePassword($request->password, $request->user()->password)) {
                return back()->with([
                    'message' => 'The provided password does not match our records!',
                    'status' => 400,
                    'audio' => Service::warningAudio(),
                ]);
            }
            $request->session()->passwordConfirmed();
            return redirect()->intended();
        }
        return back()->with([
            'message' => 'The password must be provided!', 
            'status' => 400,
            'audio' => Service::warningAudio(),
        ]);
    }
}
