<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationViewController extends Controller
{
    public function index()
    {
        $applications = Application::orderBy('id', 'desc')->paginate(10);
        return view('application_list', compact('applications'));
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'a_student_id' => 'required|string|max:50',
            'a_sex' => 'nullable|string|max:10',
            'a_birthdate' => 'nullable|date',

            'a_last_name' => 'required|string|max:100',
            'a_given_name' => 'required|string|max:100',
            'a_middle_name' => 'nullable|string|max:100',
            'a_ext_name' => 'nullable|string|max:50',

            'a_program_name' => 'nullable|string|max:150',
            'a_year_level' => 'nullable|string|max:20',
            'a_contact_number' => 'nullable|string|max:20',
            'a_email' => 'nullable|email|max:255',
            'a_street_barangay' => 'nullable|string|max:255',
            'a_zipcode' => 'nullable|string|max:10',

            'a_father_last_name' => 'nullable|string|max:100',
            'a_father_given_name' => 'nullable|string|max:100',
            'a_father_middle_name' => 'nullable|string|max:100',

            'a_mother_last_name' => 'nullable|string|max:100',
            'a_mother_given_name' => 'nullable|string|max:100',
            'a_mother_middle_name' => 'nullable|string|max:100',

            'a_disability' => 'nullable|string|max:255',
            'a_indigenous_group' => 'nullable|string|max:255',
        ]);

        Application::create([
            'student_id' => $validated['a_student_id'],
            'sex' => $validated['a_sex'] ?? null,
            'birthdate' => $validated['a_birthdate'] ?? null,

            'last_name' => $validated['a_last_name'],
            'given_name' => $validated['a_given_name'],
            'middle_name' => $validated['a_middle_name'] ?? null,
            'ext_name' => $validated['a_ext_name'] ?? null,

            'program_name' => $validated['a_program_name'] ?? null,
            'year_level' => $validated['a_year_level'] ?? null,
            'contact_number' => $validated['a_contact_number'] ?? null,
            'email' => $validated['a_email'] ?? null,
            'street_barangay' => $validated['a_street_barangay'] ?? null,
            'zipcode' => $validated['a_zipcode'] ?? null,

            'father_last_name' => $validated['a_father_last_name'] ?? null,
            'father_given_name' => $validated['a_father_given_name'] ?? null,
            'father_middle_name' => $validated['a_father_middle_name'] ?? null,

            'mother_last_name' => $validated['a_mother_last_name'] ?? null,
            'mother_given_name' => $validated['a_mother_given_name'] ?? null,
            'mother_middle_name' => $validated['a_mother_middle_name'] ?? null,

            'disability' => $validated['a_disability'] ?? null,
            'indigenous_group' => $validated['a_indigenous_group'] ?? null,

            // ✅ always pending kapag bagong create
            'status' => 'pending'
        ]);

        return back()->with('success', 'Application created successfully!');
    }

    public function approve(Request $r)
    {
        $r->validate([
            'id' => 'required|integer|exists:tblapplication,id',
        ]);

        $app = Application::findOrFail($r->id);

        if (($app->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'Application already processed.');
        }

        $app->status = 'approved';
        $app->save();

        return back()->with('success', '✅ Application approved successfully!');
    }

    public function reject(Request $r)
    {
        $r->validate([
            'id' => 'required|integer|exists:tblapplication,id',
        ]);

        $app = Application::findOrFail($r->id);

        if (($app->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'Application already processed.');
        }

        $app->status = 'rejected';
        $app->save();

        return back()->with('success', '❌ Application rejected successfully!');
    }

    public function edit($id)
    {
        return response()->json(Application::findOrFail($id));
    }

    public function show($id)
    {
        return response()->json(Application::findOrFail($id));
    }

    public function update(Request $r)
    {
        $validated = $r->validate([
            'ea_id' => 'required|integer|exists:tblapplication,id',

            'ea_last_name' => 'required|string|max:100',
            'ea_given_name' => 'required|string|max:100',

            'ea_student_id' => 'nullable|string|max:50',
            'ea_sex' => 'nullable|string|max:10',
            'ea_birthdate' => 'nullable|date',
            'ea_middle_name' => 'nullable|string|max:100',
            'ea_ext_name' => 'nullable|string|max:50',

            'ea_program_name' => 'nullable|string|max:150',
            'ea_year_level' => 'nullable|string|max:20',
            'ea_contact_number' => 'nullable|string|max:20',
            'ea_email' => 'nullable|email|max:255',
            'ea_street_barangay' => 'nullable|string|max:255',
            'ea_zipcode' => 'nullable|string|max:10',

            'ea_father_last_name' => 'nullable|string|max:100',
            'ea_father_given_name' => 'nullable|string|max:100',
            'ea_father_middle_name' => 'nullable|string|max:100',

            'ea_mother_last_name' => 'nullable|string|max:100',
            'ea_mother_given_name' => 'nullable|string|max:100',
            'ea_mother_middle_name' => 'nullable|string|max:100',

            'ea_disability' => 'nullable|string|max:255',
            'ea_indigenous_group' => 'nullable|string|max:255',
        ]);

        $app = Application::findOrFail($validated['ea_id']);

        $app->update([
            'student_id' => $validated['ea_student_id'] ?? $app->student_id,
            'sex' => $validated['ea_sex'] ?? $app->sex,
            'birthdate' => $validated['ea_birthdate'] ?? $app->birthdate,

            'last_name' => $validated['ea_last_name'],
            'given_name' => $validated['ea_given_name'],
            'middle_name' => $validated['ea_middle_name'] ?? $app->middle_name,
            'ext_name' => $validated['ea_ext_name'] ?? $app->ext_name,

            'program_name' => $validated['ea_program_name'] ?? $app->program_name,
            'year_level' => $validated['ea_year_level'] ?? $app->year_level,
            'contact_number' => $validated['ea_contact_number'] ?? $app->contact_number,
            'email' => $validated['ea_email'] ?? $app->email,
            'street_barangay' => $validated['ea_street_barangay'] ?? $app->street_barangay,
            'zipcode' => $validated['ea_zipcode'] ?? $app->zipcode,

            'father_last_name' => $validated['ea_father_last_name'] ?? $app->father_last_name,
            'father_given_name' => $validated['ea_father_given_name'] ?? $app->father_given_name,
            'father_middle_name' => $validated['ea_father_middle_name'] ?? $app->father_middle_name,

            'mother_last_name' => $validated['ea_mother_last_name'] ?? $app->mother_last_name,
            'mother_given_name' => $validated['ea_mother_given_name'] ?? $app->mother_given_name,
            'mother_middle_name' => $validated['ea_mother_middle_name'] ?? $app->mother_middle_name,

            'disability' => $validated['ea_disability'] ?? $app->disability,
            'indigenous_group' => $validated['ea_indigenous_group'] ?? $app->indigenous_group,
        ]);

        return back()->with('success', 'Application updated successfully!');
    }

    public function destroy(Request $r)
    {
        $validated = $r->validate([
            'da_id' => 'required|integer|exists:tblapplication,id',
        ]);

        Application::where('id', $validated['da_id'])->delete();

        return back()->with('success', 'Application deleted successfully!');
    }
}