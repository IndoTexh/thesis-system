<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SupervisorClassController extends Controller
{
    public function create() 
    {
        return Inertia::render('SupervisorClass/Create');
    }
}
