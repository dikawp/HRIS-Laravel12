@extends('layouts.app')

@section('title', 'Edit Leave Request')

@section('content')
    <div class="container mx-auto py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Leave Request</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Modify your existing leave request details below.
            </p>
        </div>

        <!-- Form Card -->
        <div class="mx-auto rounded-xl bg-white shadow-md dark:bg-gray-800 transition">
            <form action="{{ route('my-leaves.update', $leaveRequest->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Error Message -->
                @if ($errors->any())
                    <div
                        class="p-4 border border-red-400 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-200">
                        <p class="font-semibold">Please fix the following errors:</p>
                        <ul class="mt-2 ml-5 list-disc text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Leave Type -->
                <div>
                    <label for="leave_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Leave Type
                    </label>
                    <select id="leave_type" name="leave_type" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="0" {{ old('leave_type', $leaveRequest->leave_type) == 0 ? 'selected' : '' }}>
                            Sick Leave</option>
                        <option value="1" {{ old('leave_type', $leaveRequest->leave_type) == 1 ? 'selected' : '' }}>
                            Annual Leave</option>
                        <option value="2" {{ old('leave_type', $leaveRequest->leave_type) == 2 ? 'selected' : '' }}>
                            Other</option>
                    </select>
                    @error('leave_type')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Date Range
                    </label>
                    <div class="flex items-center gap-4 mt-1">
                        <input type="date" name="start_date" id="start_date" required
                            value="{{ old('start_date', $leaveRequest->start_date->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="text-gray-500 dark:text-gray-400">to</span>
                        <input type="date" name="end_date" id="end_date" required
                            value="{{ old('end_date', $leaveRequest->end_date->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    @error('start_date')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('end_date')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Reason
                    </label>
                    <textarea id="reason" name="reason" rows="3" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">{{ old('reason', $leaveRequest->reason) }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Attachment (Optional)
                    </label>
                    @if ($leaveRequest->attachment)
                        <div class="mt-2 text-sm">
                            <p class="text-gray-700 dark:text-gray-300">
                                Current attachment:
                                <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank"
                                    class="text-indigo-600 hover:underline dark:text-indigo-400">
                                    {{ basename($leaveRequest->attachment) }}
                                </a>
                            </p>
                            <p class="text-gray-500 dark:text-gray-400">You can upload a new file to replace it.</p>
                        </div>
                    @endif
                    <input type="file" name="attachment" id="attachment"
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                    @error('attachment')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('my-leaves.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Update Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
