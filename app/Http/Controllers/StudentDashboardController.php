<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class StudentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    public function index()
    {
        $student = Auth::guard('student')->user();

        $application = Application::where('student_id', $student->student_id)
            ->latest('id')
            ->first();

        return view('student.auth.dashboard', compact('student', 'application'));
    }
}