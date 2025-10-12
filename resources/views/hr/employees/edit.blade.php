@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="ml-4 text-2xl font-bold text-gray-800 dark:text-gray-100">
                Edit Employee
            </h2>
        </div>

        {{-- Form Wrapper --}}
        <div
            class="bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 shadow-lg rounded-2xl p-6 md:p-8">

            {{-- Alert Error --}}
            @if ($errors->any())
                <div
                    class="mb-6 flex items-start gap-4 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                    <div>
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm1-4a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-800 dark:text-red-300">There were some errors with your submission
                        </h3>
                        <ul class="list-disc ml-5 mt-2 text-sm text-red-700 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- SECTION 1: Login Information --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Login Information</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $employee->user->name) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                Address</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $employee->user->email) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div class="md:col-span-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New
                                Password</label>
                            <input type="password" name="password" id="password" placeholder="Fill only to change password"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank if you don't want to change
                                the password.</p>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Personal & Employment Information --}}
                <div class="space-y-4 mt-8">
                    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Personal & Employment Information
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full
                                Name</label>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', $employee->full_name) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIK
                                (Employee ID)</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $employee->nik) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div>
                            <label for="department_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                            <select name="department_id" id="department_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="position_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                            <select name="position_id" id="position_id" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire
                                Date</label>
                            <input type="date" name="hire_date" id="hire_date"
                                value="{{ old('hire_date', $employee->hire_date) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div>
                            <label for="date_of_birth"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                value="{{ old('date_of_birth', $employee->date_of_birth) }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div>
                            <label for="gender"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                            <select name="gender" id="gender" required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                                <option value="Male"
                                    {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female"
                                    {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="phone_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $employee->phone_number) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">
                        </div>
                        <div class="md:col-span-2">
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5">{{ old('address', $employee->address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('employees.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white dark:text-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
