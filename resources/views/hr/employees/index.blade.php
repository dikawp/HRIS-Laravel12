@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen py-6">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                Employee List
            </h1>
            <a href="{{ route('employees.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add New Employee
            </a>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="mb-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-md flex justify-between items-center"
                role="alert">
                <p class="font-medium">{{ session('success') }}</p>
                <button onclick="document.getElementById('success-alert').style.display='none'"
                    class="text-green-500 hover:text-green-700 dark:hover:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">No</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Full Name</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Email</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Department</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Position</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Hire Date</th>
                            <th scope="col" class="px-6 py-3 text-center whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr
                                class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors duration-150">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $employee->full_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">{{ $employee->department->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $employee->position->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center space-x-4">
                                        <a href="{{ route('employees.edit', $employee->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>

                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 px-6 text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="font-semibold">No Employees Found</p>
                                        <p class="text-sm">Add a new employee to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
