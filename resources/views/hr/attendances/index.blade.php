@extends('layouts.app')

@section('content')
    <div class="container mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Employee Attendance History
        </h2>

        <!-- Filter and Actions Section -->
        <div class="px-4 py-4 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('attendances.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row items-end justify-between gap-4">
                    <div x-data="{
                        open: false,
                        search: '',
                        selectedEmployeeId: '{{ $selectedEmployee->id ?? '' }}',
                        selectedEmployeeName: '{{ $selectedEmployee->full_name ?? '-- Choose Employee --' }}',
                        employees: {{ json_encode($allEmployees->map(fn($emp) => ['id' => $emp->id, 'name' => $emp->full_name])) }}
                    }" @click.away="open = false" class="relative flex-1 w-full dark:text-gray-300">

                        <input type="hidden" name="employee_id" x-model="selectedEmployeeId">

                        <button type="button" @click="open = !open"
                            class="flex items-center justify-between w-full px-3 py-2.5 text-sm text-left bg-white border border-gray-300 rounded-lg dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <span x-text="selectedEmployeeName"></span>
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition
                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-700 dark:border-gray-600 max-h-60 overflow-y-auto">
                            <input type="text" x-model="search" placeholder="Search for employee..."
                                class="w-full px-3 py-2 border-b border-gray-200 dark:border-gray-600 focus:outline-none dark:bg-gray-700 dark:text-gray-300">

                            <ul class="py-1">
                                <template
                                    x-for="employee in employees.filter(e => e.name.toLowerCase().includes(search.toLowerCase()))"
                                    :key="employee.id">
                                    <li @click="selectedEmployeeId = employee.id; selectedEmployeeName = employee.name; open = false;"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                                        :class="{ 'bg-blue-100 dark:bg-blue-900': selectedEmployeeId == employee.id }">
                                        <span x-text="employee.name"></span>
                                    </li>
                                </template>
                                <template
                                    x-if="employees.filter(e => e.name.toLowerCase().includes(search.toLowerCase())).length === 0">
                                    <li class="px-3 py-2 text-sm text-gray-500">No employees found.</li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-end space-x-2 w-full sm:w-auto">
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400">
                            View History
                        </button>

                        <a href="{{ route('attendances.create') }}"
                            class="px-5 py-2.5 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Add Manual
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Employee Profile Card -->
            @if ($selectedEmployee)
                <div class="lg:col-span-4">
                    {{-- Employee Profile Card --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
                        <div class="p-6">
                            {{-- Header: Avatar, Name, Position --}}
                            <div class="flex items-center space-x-5">
                                <div class="relative flex-shrink-0">
                                    @if ($selectedEmployee->photo)
                                        <img class="w-20 h-20 rounded-full object-cover"
                                            src="{{ asset('storage/' . $selectedEmployee->photo) }}"
                                            alt="{{ $selectedEmployee->full_name }}">
                                    @else
                                        <div
                                            class="relative w-20 h-20 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                            <svg class="absolute w-24 h-24 text-gray-400 -left-2" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000   6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    {{-- Status Badge --}}
                                    <span
                                        class="absolute bottom-0 right-0 block h-4 w-4 rounded-full bg-green-400 ring-2 ring-white dark:ring-gray-800"
                                        title="Active"></span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-lg font-bold text-gray-800 dark:text-gray-100 truncate">
                                        {{ $selectedEmployee->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $selectedEmployee->position->name }}
                                    </p>
                                </div>
                            </div>

                            <hr class="my-5 border-gray-200 dark:border-gray-700">

                            {{-- Details Section --}}
                            <div class="space-y-4">
                                {{-- Employment Details --}}
                                <div>
                                    <h4 class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">
                                        Employment Details</h4>
                                    <dl class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex justify-between">
                                            <dt class="font-medium text-gray-600 dark:text-gray-400">Employee ID</dt>
                                            <dd>{{ $selectedEmployee->nik ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-medium text-gray-600 dark:text-gray-400">Joining Date</dt>
                                            <dd>{{ \Carbon\Carbon::parse($selectedEmployee->hire_date)->format('d M Y') }}
                                            </dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-medium text-gray-600 dark:text-gray-400">Department</dt>
                                            <dd>{{ $selectedEmployee->department->name ?? 'N/A' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                {{-- Contact Information --}}
                                <div>
                                    <h4 class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">
                                        Contact</h4>
                                    <dl class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <a href="mailto:{{ $selectedEmployee->user->email }}"
                                                class="hover:underline">{{ $selectedEmployee->user->email }}</a>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            <span>{{ $selectedEmployee->phone_number ?? 'N/A' }}</span>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t dark:border-gray-700 flex gap-3">
                            <a href="{{ route('employees.show', $selectedEmployee->id) }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                                View Profile
                            </a>
                            <a href="{{ route('employees.edit', $selectedEmployee->id) }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-white dark:text-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Attendance History Table -->
            <div class="{{ $selectedEmployee ? 'lg:col-span-8' : 'col-span-full' }}">
                @if ($selectedEmployee)
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Check In</th>
                                        <th class="px-4 py-3">Check Out</th>
                                        <th class="px-4 py-3">Work Hours</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @forelse($attendanceHistory as $log)
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <td class="px-4 py-3 text-sm">
                                                {{ \Carbon\Carbon::parse($log->date)->format('d M Y, l') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ $log->check_in ? \Carbon\Carbon::parse($log->check_in)->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">{{ $log->work_hours ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                <a href="{{ route('attendances.edit', $log->id) }}"
                                                    class="px-2 py-1 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                                No attendance history found for this employee.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($attendanceHistory && $attendanceHistory->hasPages())
                            <div
                                class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                {{ $attendanceHistory->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex items-center justify-center p-6 bg-white rounded-lg shadow-md dark:bg-gray-800"
                        style="min-height: 300px;">
                        <p class="text-center text-gray-600 dark:text-gray-400">
                            Please select an employee to view their attendance history.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
