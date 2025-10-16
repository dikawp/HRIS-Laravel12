@extends('layouts.app')

@section('content')

    <h2 class="my-6 text-2xl font-semibold text-gray-800 dark:text-gray-100">
        Edit Attendance Record
    </h2>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
                <p class="font-semibold mb-1">Oops! Something went wrong:</p>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Employee --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Employee
                    </label>
                    <input type="text" value="{{ $attendance->employee->full_name }}"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800 dark:text-gray-400 cursor-not-allowed"
                        readonly disabled>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Date
                    </label>
                    <input type="date" name="date" value="{{ old('date', $attendance->date) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Status
                    </label>
                    <select name="status"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="Hadir" @selected(old('status', $attendance->status) == 'Hadir')>Hadir</option>
                        <option value="Sakit" @selected(old('status', $attendance->status) == 'Sakit')>Sakit</option>
                        <option value="Izin" @selected(old('status', $attendance->status) == 'Izin')>Izin</option>
                        <option value="Cuti" @selected(old('status', $attendance->status) == 'Cuti')>Cuti</option>
                        <option value="Alpa" @selected(old('status', $attendance->status) == 'Alpa')>Alpa</option>
                    </select>
                </div>

                {{-- Check In --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Check In
                    </label>
                    <input type="time" name="check_in" value="{{ old('check_in', $attendance->check_in) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Check Out --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Check Out
                    </label>
                    <input type="time" name="check_out" value="{{ old('check_out', $attendance->check_out) }}"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Notes (Optional)
                    </label>
                    <textarea name="notes" rows="3"
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('notes', $attendance->notes) }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end space-x-2 pt-4">
                <a href="{{ route('attendances.index', ['employee_id' => $attendance->employee_id]) }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    Update Record
                </button>
            </div>
        </form>
    </div>
@endsection
