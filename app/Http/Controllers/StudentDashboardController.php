<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    public function index()
    {
        $student = Auth::guard('student')->user();
        return view('student.dashboard', compact('student'));
    }
}