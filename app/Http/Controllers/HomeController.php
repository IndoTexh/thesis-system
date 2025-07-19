<?php

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
        /* if (Auth::user()->allow_access == Service::trueValue()) {
            return Inertia::render('Dashboard');
        }
        return redirect('/')->with("message", "You won't be able to login until the admin activate your account"); */
    }
}
