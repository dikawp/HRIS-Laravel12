@extends('layouts.app')

@section('content')
    <div class="container mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Attendance Monitoring
        </h2>
        <p class="mb-4 -mt-4 text-sm text-gray-600 dark:text-gray-400">
            {{ now()->translatedFormat('l, d F Y') }}
        </p>

        <div class="grid gap-4 mb-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    {{-- Icon for Total Employees --}}
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total Employees</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $totalEmployees }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    {{-- Icon for Present --}}
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Present (Today)</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $presentToday }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                    {{-- Icon for Absent --}}
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Absent (Today)</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $absentToday }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    {{-- Icon for Working Days --}}
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                        <path
                            d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Working Days (This Month)</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $workingDays }}</p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 sticky left-0 bg-gray-50 dark:bg-gray-800">Employee Name</th>

                            {{-- Gunakan perulangan dari array $dates --}}
                            @foreach ($dates as $dateInfo)
                                <th @class([
                                    'px-2 py-3 text-center',
                                    'bg-red-200 dark:bg-red-800 text-red-700 dark:text-red-200' =>
                                        $dateInfo['is_sunday'],
                                ])>
                                    {{ str_pad($dateInfo['day'], 2, '0', STR_PAD_LEFT) }}
                                </th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($employees as $employee)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm font-semibold sticky left-0 bg-white dark:bg-gray-800">
                                    {{ $employee->full_name }}</td>

                                {{-- Gunakan perulangan dari array $dates --}}
                                @foreach ($dates as $dateInfo)
                                    @php
                                        // Pencarian sekarang lebih sederhana
                                        $attendance = $employee->attendances->firstWhere(
                                            'date',
                                            $dateInfo['date_full']->toDateString(),
                                        );
                                    @endphp
                                    <td @class([
                                        'px-2 py-3 text-sm text-center',
                                        'bg-red-100 dark:bg-red-900/50' => $dateInfo['is_sunday'],
                                    ])>
                                        @if ($attendance)
                                            @if ($attendance->status == 'Hadir')
                                                <span title="Hadir" class="text-green-500 font-bold">✓</span>
                                            @elseif(in_array($attendance->status, ['Sakit', 'Izin']))
                                                <span title="{{ $attendance->status }}"
                                                    class="text-yellow-500 font-bold">!</span>
                                            @elseif($attendance->status == 'Cuti')
                                                <span title="Cuti" class="text-blue-500 font-bold">C</span>
                                            @else
                                                <span title="{{ $attendance->status }}"
                                                    class="text-red-500 font-bold">✗</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div
                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
@endsection
