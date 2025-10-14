<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAttendanceController extends Controller
{
    /**
     * Menampilkan halaman absensi untuk karyawan yang login.
     */
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee; // Asumsi relasi 'employee' sudah ada di model User

        // Cari data absensi hari ini
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->first();

        // Ambil riwayat absensi bulan ini
        $monthlyAttendance = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', today()->month)
            ->whereYear('date', today()->year)
            ->orderBy('date', 'desc')
            ->get();

        return view('userAttendance.index', compact('todayAttendance', 'monthlyAttendance'));
    }

    /**
     * Proses Check-in
     */
    public function checkIn(Request $request)
    {
        $employee = Auth::user()->employee;

        // Cek apakah sudah check-in hari ini
        $alreadyCheckedIn = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->exists();

        if ($alreadyCheckedIn) {
            return redirect()->route('my.attendance.index')->with('error', 'You have already checked in today.');
        }

        // Buat record absensi baru
        Attendance::create([
            'employee_id' => $employee->id,
            'date' => today(),
            'check_in' => now(),
            'status' => 'Hadir',
        ]);

        return redirect()->route('my.attendance.index')->with('success', 'Check-in successful!');
    }

    /**
     * Proses Check-out
     */
    public function checkOut(Request $request)
    {
        $employee = Auth::user()->employee;

        // Cari record absensi hari ini yang belum check-out
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', today())
            ->whereNull('check_out')
            ->first();

        if (!$attendance) {
            return redirect()->route('my.attendance.index')->with('error', 'No active check-in found to check-out.');
        }

        // Update waktu check-out
        $attendance->update([
            'check_out' => now(),
        ]);

        return redirect()->route('my.attendance.index')->with('success', 'Check-out successful!');
    }
}
