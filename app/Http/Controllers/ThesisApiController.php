<?php

namespace App\Http\Controllers;

use App\Constants\ThesisStatus;
use App\Models\Theses;
use App\Models\User;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThesisApiController extends Controller
{

    private ThesisStatus $thesisStatus;

    public function __construct(ThesisStatus $thesisStatus)
    {
        $this->thesisStatus = $thesisStatus;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        $thesis = Theses::where('user_id', $request->user_id)->where('title', $request->title)->first();
        if ($thesis) {
            Storage::disk('public')->delete($thesis->file_path);
            $thesis->update([
                'abstract' => $request->abstract,
                'file_path' => $request->file('document')->store('theses', 'public'),
                'status' => $this->thesisStatus->Submitted
            ]);
            return response()->json([
                'message' => 'Thesis updated successfully',
                'thesis' => $thesis,
            ], 200);
        }

        $thesis = Theses::create([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'file_path' => $request->file('document')->store('theses', 'public'),
            'status' => $this->thesisStatus->Submitted
        ]);
        return response()->json([
            'message' => 'Thesis uploaded successfully',
            'thesis' => $thesis,
        ], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240',
        ]);

        $thesis = Theses::where('íd', $request->thesis_id)->first();
        if ($thesis) {
            $thesis->title = $request->title;
            $thesis->abstract = $request->abstract;
            if (isset($request->document)) {
                Storage::disk('public')->delete($thesis->file_path);
                $thesis->file_path = $request->file('document')->store('theses', 'public');
            }
            $thesis->save();
            return response()->json([
                'message' => 'Thesis updated successfully',
                'thesis' => $thesis,
            ], 200);
        }
        return response()->json([
            'message' => Service::thesisNotFound(),
            'thesis' => $thesis,
        ], 404);
    }
}
