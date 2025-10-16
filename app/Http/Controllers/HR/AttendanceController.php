<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman riwayat absensi per karyawan.
     */
    public function index(Request $request)
    {
        $allEmployees = Employee::orderBy('full_name')->get();
        $selectedEmployee = null;
        $attendanceHistory = null;

        if ($request->filled('employee_id')) {
            $selectedEmployee = Employee::find($request->employee_id);
            if ($selectedEmployee) {
                $attendanceHistory = Attendance::where('employee_id', $selectedEmployee->id)
                    ->latest('date')
                    ->paginate(15);
            }
        }

        return view('hr.attendances.index', compact('allEmployees', 'selectedEmployee', 'attendanceHistory'));
    }

    /**
     * Menampilkan form untuk menambah absensi manual.
     */
    public function create(Request $request)
    {
        $employees = Employee::orderBy('full_name')->get();
        // Ambil employee_id dari request untuk pre-select dropdown
        $selectedEmployeeId = $request->input('employee_id');
        return view('hr.attendances.create', compact('employees', 'selectedEmployeeId'));
    }

    /**
     * Menyimpan absensi manual baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => [
                'required',
                'date',
                Rule::unique('attendances')->where(fn($query) => $query->where('employee_id', $request->employee_id))
            ],
            'status' => 'required|string',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after_or_equal:check_in',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendances.index', ['employee_id' => $request->employee_id])
            ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Menampilkan form edit untuk absensi.
     */
    public function edit(Attendance $attendance)
    {
        return view('hr.attendances.edit', compact('attendance'));
    }

    /**
     * Mengupdate data absensi.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|string',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after_or_equal:check_in',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index', ['employee_id' => $attendance->employee_id])
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Menghapus data absensi.
     */
    public function destroy(Attendance $attendance)
    {
        $employeeId = $attendance->employee_id;
        $attendance->delete();

        return redirect()->route('attendances.index', ['employee_id' => $employeeId])
            ->with('success', 'Attendance record deleted successfully.');
    }
}
