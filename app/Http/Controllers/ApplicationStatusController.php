<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationStatusController extends Controller
{
    public function index(Request $request)
    {
        $application = null;

        // only search if may input
        if ($request->filled('student_id')) {
            $request->validate([
                'student_id' => 'required'
            ]);

            $application = Application::where('student_id', $request->student_id)
                ->latest()
                ->first();
        }

        return view('application.lookup', compact('application'));
    }
}