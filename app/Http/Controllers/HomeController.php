<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function home() {
        sleep(1);
        return Inertia::render('Home');
    }
}
