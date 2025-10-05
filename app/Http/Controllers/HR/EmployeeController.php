<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('hr.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari employee berdasarkan ID, jika tidak ketemu akan error 404 (Not Found)
        $employee = Employee::findOrFail($id);

        $departments = Department::orderBy('name')->get();
        $positions = Position::orderBy('name')->get();

        return view('hr.employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari employee yang akan diupdate
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->user_id)],
            'password' => 'nullable|string|min:8',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        // Update data User
        $user = $employee->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update data Employee
        $employee->update($request->except(['name', 'email', 'password']));

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari employee yang akan dihapus
        $employee = Employee::findOrFail($id);

        // Hapus user terkait, employee akan terhapus otomatis via onDelete('cascade')
        $employee->user->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
