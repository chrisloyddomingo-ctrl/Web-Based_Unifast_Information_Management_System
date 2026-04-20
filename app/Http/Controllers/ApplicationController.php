<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Semester;

class ApplicationController extends Controller
{
    public function create()
    {
        return view('apply.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required','string','max:50'],
            'sex' => ['required','in:M,F'],
            'birthdate' => ['required','date'],

            'last_name' => ['required','string','max:100'],
            'given_name' => ['required','string','max:100'],
            'middle_name' => ['required','string','max:100'],
            'ext_name' => ['nullable','string','max:20'],

            'program_name' => ['required','string','max:150'],
            'program_name_other' => ['required_if:program_name,__OTHER__','nullable','string','max:150'],
            'year_level' => ['required','string','max:50'],

            'first_generation' => ['required','in:0,1'],
            'parents_monthly_income' => ['required','in:below_5000,5000_10000,10000_20000,20000_40000,above_40000'],

            'father_last_name' => ['required','string','max:100'],
            'father_given_name' => ['required','string','max:100'],
            'father_middle_name' => ['required','string','max:100'],

            'mother_last_name' => ['required','string','max:100'],
            'mother_given_name' => ['required','string','max:100'],
            'mother_middle_name' => ['required','string','max:100'],

            'street_barangay' => ['required','string','max:255'],
            'zipcode' => ['required','string','max:10'],
            'contact_number' => ['required','string','max:30'],
            'email' => ['required','email','max:150'],

            'disability' => ['nullable','string','max:255'],
            'indigenous_group' => ['nullable','string','max:255'],
        ]);

        if (($validated['program_name'] ?? '') === '__OTHER__') {
            $validated['program_name'] = $validated['program_name_other'];
        }

        unset($validated['program_name_other']);

        $currentSemester = Semester::where('is_current', true)->first();

        if (!$currentSemester) {
            return back()
                ->withInput()
                ->with('error', 'No current semester is set. Please contact the administrator.');
        }

        if ($currentSemester->application_status !== 'open') {
            return back()
                ->withInput()
                ->with('error', 'Applications are currently closed for the active semester.');
        }

        $validated['status'] = 'pending';
        $validated['semester_id'] = $currentSemester->id;

        $application = Application::create($validated);

        session([
            'submitted' => true,
            'submitted_student_id' => $application->student_id,
        ]);

        return redirect()->route('apply.submitted');
    }

    public function submitted()
    {
        if (!session()->has('submitted') || !session()->has('submitted_student_id')) {
            return redirect()->route('apply.create');
        }

        $studentId = session('submitted_student_id');
        $application = Application::where('student_id', $studentId)->first();

        return view('apply.submitted', compact('application'));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:applications,id'],
        ]);

        $app = Application::findOrFail($request->id);

        if (($app->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'This application is no longer pending.');
        }

        $app->status = 'approved';
        $app->save();

        return back()->with('success', 'Application approved successfully.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:applications,id'],
        ]);

        $app = Application::findOrFail($request->id);

        if (($app->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'This application is no longer pending.');
        }

        $app->status = 'rejected';
        $app->save();

        return back()->with('success', 'Application rejected successfully.');
    }
}