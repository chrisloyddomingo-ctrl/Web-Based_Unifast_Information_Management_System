<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grantee;
use App\Models\Application;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('report_view.reports');
    }

    // 1. List of Grantees
    public function grantees()
    {
        $grantees = Grantee::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('report_view.grantees', compact('grantees'));
    }

    // 2. Students with Outstanding
    public function outstanding()
    {
        $students = Grantee::whereNotNull('remarks')
            ->where('remarks', '!=', '')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('report_view.outstanding', compact('students'));
    }

    // 3. Financial Disbursement
    public function disbursement()
    {
        $disbursements = Grantee::orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('report_view.disbursement', compact('disbursements'));
    }

    // 4. Grantee Attendance Summary
    public function attendance()
    {
        $attendanceSummary = Attendance::select(
                'student_number',
                'name',
                'course',
                DB::raw('COUNT(*) as total_records'),
                DB::raw('SUM(CASE WHEN time_in IS NOT NULL THEN 1 ELSE 0 END) as total_time_in'),
                DB::raw('SUM(CASE WHEN time_out IS NOT NULL THEN 1 ELSE 0 END) as total_time_out')
            )
            ->groupBy('student_number', 'name', 'course')
            ->orderBy('name')
            ->get();

        return view('report_view.attendance', compact('attendanceSummary'));
    }

    // a. Reports for PWD
    public function pwd()
    {
        $pwdStudents = Application::whereNotNull('disability')
            ->where('disability', '!=', '')
            ->orderBy('last_name')
            ->orderBy('given_name')
            ->get();

        return view('report_view.pwd', compact('pwdStudents'));
    }

    // b. Parents Income
    public function parentsIncome()
    {
        $students = Application::orderBy('parents_monthly_income')
            ->orderBy('last_name')
            ->orderBy('given_name')
            ->get();

        return view('report_view.parents_income', compact('students'));
    }

    // c. Generation
    public function generation()
    {
        $students = Application::whereNotNull('first_generation')
            ->where('first_generation', '!=', '')
            ->orderBy('first_generation')
            ->orderBy('last_name')
            ->orderBy('given_name')
            ->get();

        return view('report_view.generation', compact('students'));
    }
}