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
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $today = today();

        $holidaysInMonth = Holiday::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

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

        $totalEmployees = Employee::count();
        $presentToday = Attendance::whereDate('date', $today)->count();
        $absentToday = $totalEmployees - $presentToday;

        $employees = Employee::with(['attendances' => function ($query) use ($month, $year) {
            $query->whereYear('date', $year)->whereMonth('date', $month);
        }])->orderBy('full_name')->paginate(10);

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
