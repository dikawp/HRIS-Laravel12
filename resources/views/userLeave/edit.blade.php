@extends('layouts.app')

@section('title', 'Edit Leave Request')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Edit Leave Request
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('my-leaves.update', $leaveRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Leave Type -->
                    <div>
                        <label for="leave_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Leave
                            Type</label>
                        <select id="leave_type" name="leave_type" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <option value="0"
                                {{ old('leave_type', $leaveRequest->leave_type) == 0 ? 'selected' : '' }}>Sick Leave
                            </option>
                            <option value="1"
                                {{ old('leave_type', $leaveRequest->leave_type) == 1 ? 'selected' : '' }}>Annual Leave
                            </option>
                            <option value="2"
                                {{ old('leave_type', $leaveRequest->leave_type) == 2 ? 'selected' : '' }}>Personal Leave
                            </option>
                        </select>
                        @error('leave_type')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start Date & End Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Range</label>
                        <div class="flex items-center space-x-4 mt-1">
                            <input type="date" name="start_date" id="start_date" required
                                value="{{ old('start_date', $leaveRequest->start_date->format('Y-m-d')) }}"
                                class="block w-full border-gray-300 rounded-md shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="text-gray-500">to</span>
                            <input type="date" name="end_date" id="end_date" required
                                value="{{ old('end_date', $leaveRequest->end_date->format('Y-m-d')) }}"
                                class="block w-full border-gray-300 rounded-md shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        </div>
                        @error('start_date')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                        @error('end_date')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div class="md:col-span-2">
                        <label for="reason"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
                        <textarea id="reason" name="reason" rows="4" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50">{{ old('reason', $leaveRequest->reason) }}</textarea>
                        @error('reason')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Attachment -->
                    <div class="md:col-span-2">
                        <label for="attachment"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment (Optional)</label>
                        @if ($leaveRequest->attachment)
                            <div class="mt-2 text-sm">
                                <p class="dark:text-gray-300">Current attachment:
                                    <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank"
                                        class="text-purple-600 hover:underline">{{ basename($leaveRequest->attachment) }}</a>
                                </p>
                                <p class="text-gray-500 dark:text-gray-400">You can upload a new file to replace it.</p>
                            </div>
                        @endif
                        <input type="file" name="attachment" id="attachment"
                            class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        @error('attachment')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-6 space-x-4">
                    <a href="{{ route('my-leaves.index') }}"
                        class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 active:bg-gray-50 hover:bg-gray-50 focus:outline-none focus:shadow-outline-gray">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Update Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
