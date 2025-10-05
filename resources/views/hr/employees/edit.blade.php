@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8">
            Edit Employee: {{ $employee->full_name }}
        </h2>

        {{-- Form Wrapper --}}
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 md:p-8">
            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <h3 class="font-semibold mb-2">⚠️ Ada beberapa kesalahan:</h3>
                    <ul class="list-disc ml-6 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')

                {{-- SECTION 1: Login Information --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">
                        Login Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Username</span>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $employee->user->name) }}" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:outline-none p-2.5">
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Email</span>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $employee->user->email) }}" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:outline-none p-2.5">
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">New Password</span>
                            <input type="password" name="password" id="password" placeholder="Fill only to change password"
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:outline-none p-2.5">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika Anda tidak ingin mengubah password.</p>
                        </label>
                    </div>
                </div>

                {{-- SECTION 2: Personal & Employment Information --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">
                        Personal & Employment Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Full Name</span>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', $employee->full_name) }}" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">NIK (Employee ID)</span>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $employee->nik) }}"
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Department</span>
                            <select name="department_id" id="department_id" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Position</span>
                            <select name="position_id" id="position_id" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Hire Date</span>
                            <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}"
                                required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Date of Birth</span>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $employee->date_of_birth) }}" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Gender</span>
                            <select name="gender" required
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                                <option value="Laki-laki"
                                    {{ old('gender', $employee->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('gender', $employee->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Phone Number</span>
                            <input type="text" name="phone_number"
                                value="{{ old('phone_number', $employee->phone_number) }}"
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Address</span>
                            <textarea name="address" rows="3"
                                class="w-full mt-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 p-2.5">{{ old('address', $employee->address) }}</textarea>
                        </label>
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex items-center justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('employees.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit" class="">
                        Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
