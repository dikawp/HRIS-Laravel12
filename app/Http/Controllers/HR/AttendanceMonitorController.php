<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use Illuminate\Http\Request;

class AttendanceMonitorController extends Controller
{
    public function index(Request $request)
    {
        // get bulan & tahun dari request (default: bulan & tahun saat ini)
        $month = (int) $request->input('month', date('m'));
        $year = (int) $request->input('year', date('Y'));
        $today = today();

        // get daftar hari libur
        $holidaysInMonth = Holiday::whereRaw('EXTRACT(YEAR FROM date) = ?', [$year])
            ->whereRaw('EXTRACT(MONTH FROM date) = ?', [$month])
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        // Hitung jumlah hari dalam bulan
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dates = [];
        $workingDays = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = \Carbon\Carbon::createFromDate($year, $month, $day);
            $isSunday = $currentDate->isSunday();
            $isHoliday = in_array($currentDate->toDateString(), $holidaysInMonth);

            $dates[] = [
                'day' => $day,
                'date_full' => $currentDate,
                'is_sunday' => $isSunday,
            ];

            if (!$isSunday && !$isHoliday) {
                $workingDays++;
            }
        }

        // Hitung total karyawan, hadir hari ini, dan tidak hadir hari ini
        $totalEmployees = Employee::count();
        $presentToday = Attendance::whereDate('date', $today)->count();
        $absentToday = $totalEmployees - $presentToday;

        $employees = Employee::with([
            'attendances' => function ($query) use ($month, $year) {
                $query->whereRaw('EXTRACT(YEAR FROM date) = ?', [$year])
                    ->whereRaw('EXTRACT(MONTH FROM date) = ?', [$month]);
            }
        ])
            ->orderBy('full_name')
            ->paginate(10);

        return view('hr.attendances.monitoring', compact(
            'employees',
            'dates',
            'month',
            'year',
            'totalEmployees',
            'presentToday',
            'absentToday',
            'workingDays',
            'holidaysInMonth'
        ));
    }
}
