<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RoleService;
use App\Services\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivateAccController extends Controller
{
    public function showActivate()
    {
        return Inertia::render('Activate', [
            'users' => User::where('role', RoleService::supervisor())->get()
        ]);
    }

    public function activate(User $user)
    {
        if ($user->allow_access == true) {
            return back()->with([
                'message' => 'The user is already activated.',
                'code' => 201,
                'audio' => Service::warningAudio(),
            ]);
        }
        $user->allow_access = true;
        $user->save();
        return back()->with([
            'message' => 'The user is activated.',
            'code' => 200,
            'audio' => Service::successAudio(),
        ]);
    }

    public function disactivate(User $user)
    {
        if ($user->allow_access == false) {
            return back()->with([
                'message' => 'The user is already disactivated.',
                'code' => 201,
                'audio' => Service::warningAudio(),
            ]);
        }
        $user->allow_access = false;
        $user->save();
        return back()->with([
            'message' => 'The user is disactivated.',
            'code' => 200,
            'audio' => Service::successAudio(),
        ]);
    }
}
