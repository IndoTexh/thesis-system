<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Services\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MajorController extends Controller
{
    public function create()
    {
        return Inertia::render('Major/Create', [
            'majors' => Major::all(),
        ]);
    }

    public function store(Request $request)
    {
        $major = $request->validate([
            'major_name' => 'required|string|max:255'
        ]);
        Major::create($major);
        return back()->with([
            'message' => 'Major has been created!',
            'status' => 200,
            'audio' => Service::successAudio(),
        ]);
    }
}
