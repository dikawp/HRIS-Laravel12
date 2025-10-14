@extends('layouts.app')

@section('content')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        My Attendance
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Today's Attendance ({{ today()->format('d M Y') }})
        </h4>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">{{ session('error') }}</div>
        @endif

        {{-- Logika Tombol Check-in/Check-out --}}
        @if (!$todayAttendance)
            {{-- Belum Check-in --}}
            <form action="{{ route('my.attendance.checkin') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700">
                    Check In Now
                </button>
            </form>
        @elseif($todayAttendance && is_null($todayAttendance->check_out))
            {{-- Sudah Check-in, tapi belum Check-out --}}
            <p class="mb-4">You checked in at: {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }}
            </p>
            <form action="{{ route('my.attendance.checkout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700">
                    Check Out Now
                </button>
            </form>
        @else
            {{-- Sudah Check-in dan Check-out --}}
            <p>Attendance for today is complete.</p>
            <p>Check In: {{ \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') }} | Check Out:
                {{ \Carbon\Carbon::parse($todayAttendance->check_out)->format('H:i') }}</p>
        @endif
    </div>

    {{-- Riwayat Absensi Bulan Ini --}}
@endsection
