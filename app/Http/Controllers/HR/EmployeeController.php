<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data employees bersama relasi department dan position
        $employees = Employee::with(['department', 'position'])->latest()->paginate(10);
        return view('hr.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('hr.employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        // 2. Buat User baru (untuk login)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role untuk karyawan
        ]);

        // 3. Buat Employee baru dan hubungkan dengan User
        Employee::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'hire_date' => $request->hire_date,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'nik' => $request->nik,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect()->route('hr.employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
