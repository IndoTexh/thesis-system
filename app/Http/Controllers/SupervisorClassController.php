<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassSupervisor;
use App\Models\User;
use App\Services\RoleService;
use App\Services\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupervisorClassController extends Controller
{
    public function create()
    {
        return Inertia::render('SupervisorClass/Create', [
            'classes' => Classes::all(),
            'supervisors' => User::where('role', RoleService::supervisor())->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'classes_id' => 'required|integer',
            'supervisor_id' => 'required|integer'
        ]);

        $class_supervisor = ClassSupervisor::create([
            'classes_id' => $request->classes_id,
            'supervisor_id' => $request->supervisor_id
        ]);

        return back()->with([
            'message' => 'Supervisor class has been created.',
            'code' => 200,
            'audio' => Service::successAudio()
        ]);
    }

    public function myClass()
    {
        return Inertia::render('SupervisorClass/MyClass');
    }
}
