<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Services\Service;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function store(Request $request)
    {
        $class = $request->validate([
            'class_name' => 'required|string|max:255',
            'major_id' => 'required'
        ]);
        Classes::create($class);
        return back()->with([
            'message' => 'A class has been created!',
            'status' => 200,
            'audio' => Service::successAudio(),
        ]);
    }
}
