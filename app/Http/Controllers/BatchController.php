<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('scholarship')->latest()->paginate(10);
        return view('batches.index', compact('batches'));
    }

    public function create()
    {
        $scholarships = Scholarship::where('is_active', true)->get();
        return view('batches.create', compact('scholarships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        Batch::create([
            'scholarship_id' => $request->scholarship_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $scholarships = Scholarship::where('is_active', true)->get();
        return view('batches.edit', compact('batch', 'scholarships'));
    }

    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $batch->update([
            'scholarship_id' => $request->scholarship_id,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}