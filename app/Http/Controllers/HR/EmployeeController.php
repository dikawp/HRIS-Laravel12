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
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter filter
        $search = $request->query('search');
        $departmentId = $request->query('department_id');
        $positionId = $request->query('position_id');

        // Base query employees
        $query = Employee::query()
            ->select('employees.*')
            ->join('users', function ($join) {
                $join->on('employees.user_id', '=', 'users.id')
                    ->where('users.role', '=', 'user');
            })
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('positions', 'employees.position_id', '=', 'positions.id')
            ->with(['user', 'department', 'position']);

        // Search filter
        if ($search) {
            $searchTerm = "%{$search}%";
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery
                    ->where('employees.full_name', 'ILIKE', $searchTerm)
                    ->orWhere('users.email', 'ILIKE', $searchTerm)
                    ->orWhere('departments.name', 'ILIKE', $searchTerm)
                    ->orWhere('positions.name', 'ILIKE', $searchTerm);
            });
        }

        // Filter department dan position
        $query
            ->when($departmentId, fn($q) => $q->where('employees.department_id', $departmentId))
            ->when($positionId, fn($q) => $q->where('employees.position_id', $positionId));

        $employees = $query
            ->orderByDesc('employees.created_at')
            ->paginate(10)
            ->withQueryString();

        $departments = $request->ajax() ? [] : Department::orderBy('name')->get();

        // render partial table
        if ($request->ajax()) {
            return view('hr.employees.employee_table', compact('employees'))->render();
        }

        // render halaman utama
        return view('hr.employees.index', compact('employees', 'departments'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'full_name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50|unique:employees,nik',
            'phone_number' => 'nullable|string|max:20|unique:employees,phone_number',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Employee::create([
            'user_id' => $user->id,
            'full_name' => $validatedData['full_name'],
            'nik' => $validatedData['nik'],
            'phone_number' => $validatedData['phone_number'],
            'place_of_birth' => $validatedData['place_of_birth'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'gender' => $validatedData['gender'],
            'marital_status' => $validatedData['marital_status'],
            'address' => $validatedData['address'],
            'hire_date' => $validatedData['hire_date'],
            'department_id' => $validatedData['department_id'],
            'position_id' => $validatedData['position_id'],
            'photo' => $photoPath,
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
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->user_id)],
            'password' => 'nullable|string|min:8',

            'full_name' => 'required|string|max:255',
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('employees')->ignore($employee->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $employee->user;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        $employeeData = $request->except(['_token', '_method', 'name', 'email', 'password', 'photo']);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $employeeData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employee->update($employeeData);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->user->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
