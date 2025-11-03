@extends('layouts.app')

@section('title', 'Attendance History')

@section('content')
    <div class="container mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Employee Attendance History
        </h2>

        <!-- Filter and Actions Section -->
        <div class="px-4 py-4 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('attendances.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row items-end justify-between gap-4">
                    {{-- AlpineJS Dropdown for Employee Selection --}}
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
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400">
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
            @if ($selectedEmployee)
                <!-- Employee Profile Card -->
                <div class="lg:col-span-3">
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
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="text-md font-bold text-gray-800 dark:text-gray-100">
                                        {{ $selectedEmployee->full_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $selectedEmployee->position->name }}</p>
                                </div>
                            </div>
                            <hr class="my-5 border-gray-200 dark:border-gray-700">
                            {{-- Details Section --}}
                            <div class="space-y-4">
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
                                        <div class="flex justify-between">
                                            <dt class="font-medium text-gray-600 dark:text-gray-400">Work Hours</dt>
                                            <dd>{{ $selectedEmployee->schedule_start_time . ' - ' . $selectedEmployee->schedule_end_time }}</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <h4 class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">
                                        Contact</h4>
                                    <dl class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg><a href="mailto:{{ $selectedEmployee->user->email }}"
                                                class="hover:underline">{{ $selectedEmployee->user->email }}</a></div>
                                        <div class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg><span>{{ $selectedEmployee->phone_number ?? 'N/A' }}</span></div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        {{-- Footer Actions --}}
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t dark:border-gray-700 flex gap-3">
                            <a href="{{ route('employees.show', $selectedEmployee->id) }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">View
                                Profile</a>
                            <a href="{{ route('employees.edit', $selectedEmployee->id) }}"
                                class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-700 bg-white dark:text-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">Edit</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Attendance History Table -->
            <div id="attendanceContainer" class="{{ $selectedEmployee ? 'lg:col-span-9' : 'col-span-full' }}">
                @if ($selectedEmployee)
                    @include('hr.attendances.attendance_table', [
                        'attendanceHistory' => $attendanceHistory,
                    ])
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('attendanceContainer');

            if (container) {
                function fetchAttendanceTable() {
                    const employeeIdInput = document.querySelector('input[name="employee_id"]');
                    if (!employeeIdInput || !employeeIdInput.value) {
                        return;
                    }
                    const employeeId = employeeIdInput.value;
                    const year = container.querySelector('#year')?.value || '';
                    const month = container.querySelector('#month')?.value || '';

                    container.style.opacity = '0.5';
                    container.style.transition = 'opacity 0.2s linear';

                    const url = new URL('{{ route('attendances.index') }}');
                    url.searchParams.append('employee_id', employeeId);
                    url.searchParams.append('year', year);
                    url.searchParams.append('month', month);

                    fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error fetching attendance data:', error);
                            alert('Gagal memuat riwayat absensi. Silakan coba lagi.');
                        })
                        .finally(() => {
                            container.style.opacity = '1';
                        });
                }

                container.addEventListener('change', function(e) {
                    if (e.target.id === 'year' || e.target.id === 'month') {
                        fetchAttendanceTable();
                    }
                });

                container.addEventListener('click', function(e) {
                    const toggleButton = e.target.closest('.details-toggle');
                    if (!toggleButton) return;

                    const targetId = toggleButton.dataset.target;
                    const detailsRow = document.querySelector(targetId);

                    if (detailsRow) {
                        const isHidden = detailsRow.classList.toggle('hidden');
                        toggleButton.querySelector('.expand-icon').classList.toggle('hidden', !isHidden);
                        toggleButton.querySelector('.collapse-icon').classList.toggle('hidden', isHidden);
                    }
                });
            }
        });
    </script>
@endpush
