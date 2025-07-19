<?php

namespace App\Http\Controllers;

use App\Models\Theses;
use App\Services\ThesisService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThesisController extends Controller
{
    protected $thesisService;

    public function __construct(ThesisService $thesisService)
    {
        $this->thesisService = $thesisService;
    }

    public function index()
    {
        $theses = auth()->user()->theses()->with('user')->latest()->get();
        return Inertia::render('Thesis/Index', [
            'theses' => $theses,
        ]);
    }

    public function create()
    {
        return Inertia::render('Thesis/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx|max:10240',
        ]);
        $validated['document'] = $request->file('document');
        $this->thesisService->storeThesis($validated);
        return redirect()->route('theses.index')->with('message', 'Thesis submitted successfully!');
    }

    public function edit(Theses $thesis)
    {
        if ($thesis) {
            return Inertia::render('Thesis/Edit', [
                'thesis' => $thesis
            ]);
        }
        return back()->with('message', 'Thesis not found!');
    }

    public function update(Request $request, Theses $thesis)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,docx|max:10240',
        ]);
        $this->thesisService->updateThesis($thesis, $validated);
        return redirect()->route('theses.index')->with('message', 'Thesis updated successfully!');
    }
}
