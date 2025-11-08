@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="my-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Employee Details</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Complete profile information for <span class="font-semibold">{{ $employee->full_name }}</span>.
            </p>
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-900">
                Back
            </a>
            <a href="{{ route('employees.edit', $employee->id) }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Employee Card -->
    <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800">
        <!-- Header -->
        <div
            class="flex flex-col items-center sm:flex-row sm:items-center sm:space-x-6 p-6 border-b border-gray-200 dark:border-gray-700">
            <img class="h-28 w-28 rounded-full object-cover ring-4 ring-indigo-300 dark:ring-indigo-500"
                src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://placehold.co/128x128/E2E8F0/AAAAAA?text=Photo' }}"
                alt="Photo of {{ $employee->full_name }}">

            <div class="mt-4 sm:mt-0">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $employee->full_name }}</h2>
                <p class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ $employee->position?->name ?? 'Position not found' }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $employee->department?->name ?? 'Department not found' }}
                </p>

                @php
                    $statusClasses =
                        $employee->status === 'Aktif'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                @endphp
                <span class="mt-3 inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $statusClasses }}">
                    {{ ucfirst($employee->status) }}
                </span>
            </div>
        </div>

        <!-- Details Section -->
        <div class="p-6">
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- NIK -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Employee ID (NIK)</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">{{ $employee->nik }}</dd>
                </div>

                <!-- Email -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">
                        {{ $employee->user?->email ?? 'N/A' }}
                    </dd>
                </div>

                <!-- Phone -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">{{ $employee->phone_number }}</dd>
                </div>

                <!-- Birth Information -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Place & Date of Birth</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">
                        {{ $employee->place_of_birth }},
                        {{ \Carbon\Carbon::parse($employee->date_of_birth)->translatedFormat('d F Y') }}
                    </dd>
                </div>

                <!-- Gender -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">
                        {{ $employee->gender === 'male' ? 'Male' : 'Female' }}
                    </dd>
                </div>

                <!-- Marital Status -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Marital Status</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">
                        {{ ucfirst($employee->marital_status) }}
                    </dd>
                </div>

                <!-- Hire Date -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hire Date</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($employee->hire_date)->translatedFormat('d F Y') }}
                        <span class="text-gray-500 dark:text-gray-400">
                            ({{ \Carbon\Carbon::parse($employee->hire_date)->diffForHumans() }})
                        </span>
                    </dd>
                </div>

                <!-- Address -->
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                    <dd class="sm:col-span-2 text-sm text-gray-900 dark:text-white">{{ $employee->address }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
