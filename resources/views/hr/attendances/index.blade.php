@extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Attendance Monitoring
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Employee Name</th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th class="px-2 py-3 text-center">{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($employees as $employee)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">{{ $employee->full_name }}</td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        // Cari absensi untuk tanggal ini
                                        $attendance = $employee->attendances->firstWhere(
                                            'date',
                                            date('Y-m-d', mktime(0, 0, 0, $month, $day, $year)),
                                        );
                                    @endphp
                                    <td class="px-2 py-3 text-sm text-center">
                                        @if ($attendance)
                                            @if ($attendance->status == 'Hadir')
                                                <span class="text-green-500">✓</span>
                                            @elseif($attendance->status == 'Sakit' || $attendance->status == 'Izin')
                                                <span class="text-yellow-500">!</span>
                                            @else
                                                <span class="text-red-500">✗</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
