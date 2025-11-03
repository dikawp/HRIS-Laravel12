@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Apply for Leave</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Fill out the form below to request your leave.
            </p>
        </div>

        <!-- Form Card -->
        <div class="mx-auto rounded-xl bg-white shadow-md dark:bg-gray-800 transition">
            <form action="{{ route('my-leaves.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

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

                <!-- Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Reason -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
                    <textarea name="reason" rows="3" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">{{ old('reason') }}</textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment (Optional)</label>
                    <input type="file" name="attachment"
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accepted: JPG, PNG, PDF — Max size: 2MB.</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('my-leaves.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg transition hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
