<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TblUser;

class UserController extends Controller
{
    /**
     * Only admin can access this controller
     */
   public function __construct()
{
    $this->middleware('admin');
}

    /**
     * Display list of users
     */
    public function index()
    {
        $users = TblUser::orderBy('id','desc')->paginate(10);
        return view('users.users', compact('users'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:tblusers,email'],
            'password' => ['required','min:6'],
            'role' => ['required','in:admin,staff,user'],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:255'],
            'status' => ['required','in:active,inactive'],
        ]);

        TblUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success','User created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $user = TblUser::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = TblUser::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255',"unique:tblusers,email,$id"],
            'role' => ['required','in:admin,staff,user'],
            'phone' => ['nullable','string','max:30'],
            'address' => ['nullable','string','max:255'],
            'status' => ['required','in:active,inactive'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success','User updated successfully.');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = TblUser::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success','User deleted successfully.');
    }
}
