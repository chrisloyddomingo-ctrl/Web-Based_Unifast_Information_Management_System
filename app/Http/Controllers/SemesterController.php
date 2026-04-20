<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('created_at', 'desc')->get();
        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('semesters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Semester::create([
            'semester_name' => $request->semester_name,
            'school_year' => $request->school_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => false,
            'application_status' => 'closed',
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester added successfully.');
    }

    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);

        $request->validate([
            'semester_name' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $semester->update([
            'semester_name' => $request->semester_name,
            'school_year' => $request->school_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester updated successfully.');
    }

    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);

        if ($semester->is_current) {
            return redirect()
                ->route('semesters.index')
                ->with('error', 'Current semester cannot be deleted.');
        }

        $semester->delete();

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Semester deleted successfully.');
    }

    public function setCurrent($id)
    {
        $semester = Semester::findOrFail($id);

        Semester::query()->update([
            'is_current' => false,
            'application_status' => 'closed',
        ]);

        $semester->update([
            'is_current' => true,
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Current semester updated successfully.');
    }

    public function openApplication($id)
    {
        $semester = Semester::findOrFail($id);

        if (!$semester->is_current) {
            return redirect()
                ->route('semesters.index')
                ->with('error', 'Only the current semester can open applications.');
        }

        Semester::query()->update([
            'application_status' => 'closed',
        ]);

        $semester->update([
            'application_status' => 'open',
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Application opened successfully.');
    }

    public function closeApplication($id)
    {
        $semester = Semester::findOrFail($id);

        $semester->update([
            'application_status' => 'closed',
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Application closed successfully.');
    }

    public function setViewing($id)
    {
        $semester = Semester::findOrFail($id);

        Semester::query()->update([
            'is_viewing' => false,
        ]);

        $semester->update([
            'is_viewing' => true,
        ]);

        return redirect()
            ->route('semesters.index')
            ->with('success', 'Success viewing semester for '.$semester->school_year.' '.$semester->semester_name.'.');
    }
}