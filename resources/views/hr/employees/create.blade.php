@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="ml-4 text-2xl font-bold text-gray-800 dark:text-gray-100">Add New Employee</h2>
        </div>

        {{-- Card Form --}}
        <div
            class="bg-white dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg p-6 md:p-8">
            {{-- Error Alert --}}
            @if ($errors->any())
                <div
                    class="mb-6 flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm1-4a1 1 0 100 2 1 1 0 000-2z"
                            clip-rule="evenodd" />
                    </svg>
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

            {{-- Form --}}
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                {{-- SECTION 1: Login Information --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Login Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $inputClass =
                                'mt-1 block w-full rounded-lg border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition duration-150 p-2.5';
                        @endphp

                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                placeholder="e.g., john.doe" class="{{ $inputClass }}">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                placeholder="e.g., employee@example.com" class="{{ $inputClass }}">
                        </div>

                        <div class="md:col-span-2">
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input type="password" id="password" name="password" required
                                placeholder="Enter a strong password" class="{{ $inputClass }}">
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Personal & Employment Information --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                        Personal & Employment Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Full Name --}}
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full
                                Name</label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                                placeholder="e.g., John Doe" class="{{ $inputClass }}">
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label for="nik"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIK</label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                placeholder="e.g., 3578xxxxxxxxxxxx" class="{{ $inputClass }}">
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <label for="phone_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                            <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                placeholder="e.g., 081234567890" class="{{ $inputClass }}">
                        </div>

                        {{-- Place of Birth --}}
                        <div>
                            <label for="place_of_birth"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Place of Birth</label>
                            <input type="text" id="place_of_birth" name="place_of_birth"
                                value="{{ old('place_of_birth') }}" placeholder="e.g., Surabaya"
                                class="{{ $inputClass }}">
                        </div>

                        {{-- Date of Birth --}}
                        <div>
                            <label for="date_of_birth"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth') }}" required class="{{ $inputClass }}">
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label for="gender"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                            <select id="gender" name="gender" required class="{{ $inputClass }}">
                                <option value="" disabled selected>-- Select Gender --</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        {{-- Marital Status --}}
                        <div>
                            <label for="marital_status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marital Status</label>
                            <select id="marital_status" name="marital_status" class="{{ $inputClass }}">
                                <option value="" disabled selected>-- Select Status --</option>
                                @foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('marital_status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Address --}}
                        <div class="md:col-span-2">
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="Enter full address"
                                class="{{ $inputClass }}">{{ old('address') }}</textarea>
                        </div>

                        <hr class="md:col-span-2 border-gray-200 dark:border-gray-700">

                        {{-- Department --}}
                        <div>
                            <label for="department_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                            <select id="department_id" name="department_id" required class="{{ $inputClass }}">
                                <option value="" disabled selected>-- Select a Department --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Position --}}
                        <div>
                            <label for="position_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                            <select id="position_id" name="position_id" required disabled
                                class="{{ $inputClass }} disabled:bg-gray-200 dark:disabled:bg-gray-700">
                                <option value="" disabled selected>-- Select Department First --</option>
                            </select>
                        </div>

                        {{-- Hire Date --}}
                        <div>
                            <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire
                                Date</label>
                            <input type="date" id="hire_date" name="hire_date"
                                value="{{ old('hire_date', now()->toDateString()) }}" required
                                class="{{ $inputClass }}">
                        </div>

                        {{-- Photo with Preview --}}
                        <div>
                            <label for="photo"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (MAX. 2MB)</p>
                            <img id="photoPreview"
                                class="mt-3 w-24 h-24 rounded-full object-cover border border-gray-300 dark:border-gray-600 hidden"
                                alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('employees.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md focus:ring-2 focus:ring-blue-500 transition">
                        Save Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department_id');
            const positionSelect = document.getElementById('position_id');
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');

            // Department -> Position dynamic load
            departmentSelect.addEventListener('change', async function() {
                const departmentId = this.value;
                positionSelect.innerHTML = '<option disabled selected>Loading...</option>';
                positionSelect.disabled = true;

                if (!departmentId) return;

                try {
                    const res = await fetch(`/departments/${departmentId}/positions`);
                    const data = await res.json();
                    positionSelect.innerHTML =
                        '<option disabled selected>-- Select a Position --</option>';
                    data.forEach(pos => {
                        const opt = document.createElement('option');
                        opt.value = pos.id;
                        opt.textContent = pos.name;
                        positionSelect.appendChild(opt);
                    });
                    positionSelect.disabled = false;
                } catch {
                    positionSelect.innerHTML =
                        '<option disabled selected>Failed to load positions</option>';
                }
            });

            if (departmentSelect.value) departmentSelect.dispatchEvent(new Event('change'));

            // Photo preview
            photoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        photoPreview.src = e.target.result;
                        photoPreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    photoPreview.src = '';
                    photoPreview.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
