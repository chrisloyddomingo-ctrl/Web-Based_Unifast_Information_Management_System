<?php

namespace App\Http\Controllers;

use App\Models\Grantee;
use App\Models\Batch;
use App\Models\Scholarship;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Imports\GranteesImport;
use Maatwebsite\Excel\Facades\Excel;

class GranteeListController extends Controller
{
    public function index()
    {
        $batches = Batch::with('scholarship')->orderBy('name')->get();
        $scholarships = Scholarship::orderBy('name')->get();
        $grantees = Grantee::with(['batch.scholarship', 'scholarship'])
            ->orderBy('id', 'desc')
            ->get();

        $existingStudentIds = Grantee::whereNotNull('student_id')
            ->pluck('student_id')
            ->toArray();

        $newGranteesCount = Application::where('status', 'approved')
            ->whereNotIn('student_id', $existingStudentIds)
            ->whereNotNull('student_id')
            ->distinct()
            ->count('student_id');

        $totalGrantees = $grantees->count();
        $enrolledCount = $grantees->filter(fn ($g) => strtoupper($g->status_of_student ?? '') === 'ENROLLED')->count();
        $graduatedCount = $grantees->filter(fn ($g) => strtoupper($g->status_of_student ?? '') === 'GRADUATED')->count();
        $droppedCount = $grantees->filter(fn ($g) => strtoupper($g->status_of_student ?? '') === 'DROPPED')->count();

        return view('granteelist.grantee_list', compact(
            'grantees',
            'batches',
            'scholarships',
            'totalGrantees',
            'enrolledCount',
            'graduatedCount',
            'droppedCount',
            'newGranteesCount'
        ));
    }

    public function create()
    {
        $batches = Batch::with('scholarship')->orderBy('name')->get();
        $scholarships = Scholarship::orderBy('name')->get();

        return view('granteelist.addgrantee', compact('batches', 'scholarships'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => ['nullable', 'integer'],
            'student_id' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'extension_name' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'course' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'string', 'max:50'],
            'years_of_stay' => ['nullable', 'string', 'max:50'],
            'scholarship_id' => ['nullable', 'exists:scholarships,id'],
            'batch_name' => ['nullable', 'string', 'max:255'],
            'status_of_student' => ['nullable', 'in:Enrolled,Graduated,Dropped,Delisted,Not Enrolled'],
            'remarks' => ['nullable', 'string'],
        ]);

        if (empty($validated['status_of_student'])) {
            $validated['status_of_student'] = 'Enrolled';
        }

        if (!empty($validated['batch_name'])) {
            $batchQuery = Batch::query()->where('name', $validated['batch_name']);

            if (!empty($validated['scholarship_id'])) {
                $batchQuery->where('scholarship_id', $validated['scholarship_id']);
            }

            $batch = $batchQuery->first();

            if (!$batch) {
                $batch = Batch::create([
                    'name' => $validated['batch_name'],
                    'scholarship_id' => $validated['scholarship_id'] ?? null,
                ]);
            }

            $validated['batch_id'] = $batch->id;
        } else {
            $validated['batch_id'] = null;
        }

        unset($validated['batch_name']);

        Grantee::create($validated);

        return redirect()
            ->route('grantees.index')
            ->with('success', 'Grantee added successfully.');
    }

    public function show($id)
    {
        $grantee = Grantee::with(['batch.scholarship', 'scholarship'])->findOrFail($id);
        return response()->json($grantee);
    }

    public function edit($id)
    {
        $grantee = Grantee::with(['batch.scholarship', 'scholarship'])->findOrFail($id);
        return response()->json($grantee);
    }

    public function update(Request $request, $id)
    {
        $grantee = Grantee::findOrFail($id);

        $validated = $request->validate([
            'application_id' => ['nullable', 'integer'],
            'student_id' => ['nullable', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'extension_name' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:150'],
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'course' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'string', 'max:50'],
            'years_of_stay' => ['nullable', 'string', 'max:50'],
            'scholarship_id' => ['nullable', 'exists:scholarships,id'],
            'batch_name' => ['nullable', 'string', 'max:255'],
            'status_of_student' => ['required', 'in:Enrolled,Graduated,Dropped,Delisted,Not Enrolled'],
            'remarks' => ['nullable', 'string'],
        ]);

        if (!empty($validated['batch_name'])) {
            $batchQuery = Batch::query()->where('name', $validated['batch_name']);

            if (!empty($validated['scholarship_id'])) {
                $batchQuery->where('scholarship_id', $validated['scholarship_id']);
            }

            $batch = $batchQuery->first();

            if (!$batch) {
                $batch = Batch::create([
                    'name' => $validated['batch_name'],
                    'scholarship_id' => $validated['scholarship_id'] ?? null,
                ]);
            }

            $validated['batch_id'] = $batch->id;
        } else {
            $validated['batch_id'] = null;
        }

        unset($validated['batch_name']);

        $grantee->update($validated);

        return redirect()
            ->route('grantees.index')
            ->with('success', 'Grantee updated successfully.');
    }

    public function destroy($id)
    {
        $grantee = Grantee::findOrFail($id);
        $grantee->delete();

        return redirect()
            ->route('grantees.index')
            ->with('success', 'Grantee deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new GranteesImport, $request->file('file'));

        return redirect()
            ->route('grantees.index')
            ->with('success', 'Grantees imported successfully.');
    }

    public function newGrantees()
    {
        $existingStudentIds = Grantee::whereNotNull('student_id')
            ->pluck('student_id')
            ->toArray();

        $newGrantees = Application::where('status', 'approved')
            ->whereNotIn('student_id', $existingStudentIds)
            ->orderBy('id', 'desc')
            ->get();

        return view('granteelist.newgrantees', compact('newGrantees'));
    }
}