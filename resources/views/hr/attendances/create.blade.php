@extends('layouts.app')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-800 dark:text-gray-100">
            Add Manual Attendance Record
        </h2>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
            {{-- Error Message --}}
            @if ($errors->any())
                <div
                    class="mb-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 dark:bg-red-900/30 dark:border-red-600 dark:text-red-300">
                    <p class="font-semibold mb-1">Oops! Something went wrong:</p>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('attendances.store') }}" method="POST" class="space-y-6">
                @csrf
                <div x-data="{
                    open: false,
                    search: '',
                    selectedEmployeeId: '{{ old('employee_id', $selectedEmployeeId) }}',
                    selectedEmployeeName: '{{ $employees->firstWhere('id', old('employee_id', $selectedEmployeeId))?->full_name ?? '-- Choose Employee --' }}',
                    employees: {{ json_encode($employees->map(fn($emp) => ['id' => $emp->id, 'name' => $emp->full_name])) }}
                }" class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee <span
                            class="text-red-500">*</span></label>
                    <input type="hidden" name="employee_id" x-model="selectedEmployeeId">

                    <button type="button" @click="open = !open"
                        class="w-full px-3 py-2.5 text-sm flex justify-between items-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <span x-text="selectedEmployeeName"></span>
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition @click.away="open = false"
                        class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 rounded-lg shadow-xl border border-gray-200 dark:border-gray-600 overflow-hidden">
                        <input type="text" x-model="search" placeholder="Search employee..."
                            class="w-full px-3 py-2 border-b dark:border-gray-600 focus:outline-none text-sm dark:bg-gray-700 dark:text-gray-200">
                        <ul class="max-h-56 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-600">
                            <template
                                x-for="employee in employees.filter(e => e.name.toLowerCase().includes(search.toLowerCase()))"
                                :key="employee.id">
                                <li @click="selectedEmployeeId = employee.id; selectedEmployeeName = employee.name; open = false;"
                                    class="px-3 py-2 cursor-pointer text-sm hover:bg-blue-50 dark:hover:bg-gray-600 dark:text-gray-200"
                                    x-text="employee.name"></li>
                            </template>
                            <li x-show="employees.filter(e => e.name.toLowerCase().includes(search.toLowerCase())).length === 0"
                                class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">No matches found</li>
                        </ul>
                    </div>
                </div>

                {{-- Grid Form Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="check_in" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check
                            In Time</label>
                        <input type="time" id="check_in" name="check_in" value="{{ old('check_in') }}" step="1"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank if absent/leave/etc.</p>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date
                            <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                    </div>


                    <div>
                        <label for="check_out" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check
                            Out Time</label>
                        <input type="time" id="check_out" name="check_out" value="{{ old('check_out') }}" step="1"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes
                        (Optional)</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Add notes like Sick, Leave, Permit, etc."
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('notes') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end space-x-2 pt-4">
                    <a href="{{ url()->previous() }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        Save Record
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
