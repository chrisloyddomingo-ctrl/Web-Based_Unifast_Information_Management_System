<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAccountController extends Controller
{
    public function showLogin()
    {
        return view('student.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::guard('student')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.auth.login');
    }
    public function view()
    {
        $student = Auth::guard('student')->user();
        return view('student.auth.account.view', compact('student'));
    }

    public function edit()
    {
        $student = Auth::guard('student')->user();
        return view('student.auth.account.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::guard('student')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'student_number' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $student->name = $request->name;
        $student->email = $request->email;
        $student->course = $request->course;
        $student->year_level = $request->year_level;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('student.account.view')->with('success', 'Account updated successfully.');
    }

    public function deactivateForm()
    {
        $student = Auth::guard('student')->user();
        return view('student.auth.account.deactivate', compact('student'));
    }

    public function deactivate(Request $request)
    {
        $student = Auth::guard('student')->user();

        $request->validate([
            'password' => 'required'
        ]);

        if (!Hash::check($request->password, $student->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        $student->status = 'deactivated';
        $student->save();

        Auth::guard('student')->logout();

        return redirect()->route('login')->with('success', 'Your account has been deactivated.');
    }
}