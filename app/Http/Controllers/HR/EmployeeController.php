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
    public function index(Request $request)
    {
        $search = $request->query('search');
        $departmentId = $request->query('department_id');
        $positionId = $request->query('position_id');

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
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('employees.full_name', 'ILIKE', "%{$search}%")
                    ->orWhere('users.email', 'ILIKE', "%{$search}%")
                    ->orWhere('departments.name', 'ILIKE', "%{$search}%")
                    ->orWhere('positions.name', 'ILIKE', "%{$search}%");
            });
        }

        // Department
        $query->when($departmentId, function ($q, $deptId) {
            $q->where('employees.department_id', $deptId);
        });

        // Position
        $query->when($positionId, function ($q, $posId) {
            $q->where('employees.position_id', $posId);
        });

        $employees = $query
            ->orderByDesc('employees.created_at')
            ->paginate(10)
            ->withQueryString();

        $departments = $request->ajax() ? [] : Department::orderBy('name')->get();

        // AJAX partial render
        if ($request->ajax()) {
            return view('hr.employees.employee_table', compact('employees'))->render();
        }

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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
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

        $employee->update($request->except(['name', 'email', 'password']));

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
