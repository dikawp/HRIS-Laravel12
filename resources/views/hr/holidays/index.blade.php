@extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Manage Holidays
        </h2>

        <!-- Card Container -->
        <div class="w-full overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-md">

            <!-- Add Holiday Form -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <form action="{{ route('holidays.store') }}" method="POST"
                    class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    @csrf

                    <!-- Date -->
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Date
                        </label>
                        <input type="date" id="date" name="date" value="{{ old('date') }}"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                        @error('date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="flex-[2]">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Description
                        </label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}"
                            placeholder="e.g., New Year's Day"
                            class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                        @error('description')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div>
                        <button type="submit"
                            class="flex items-center justify-center w-full px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 active:bg-blue-800 focus:ring-2 focus:ring-blue-400 focus:outline-none transition-all duration-150">
                            + Add Holiday
                        </button>
                    </div>
                </form>
            </div>

            <!-- Holiday List Table -->
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left uppercase text-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-gray-400 border-b dark:border-gray-700">
                            <th class="px-5 py-3">Date</th>
                            <th class="px-5 py-3">Description</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($holidays as $holiday)
                            <tr
                                class="text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                <td class="px-5 py-3 font-medium">
                                    {{ \Carbon\Carbon::parse($holiday->date)->format('d F Y, l') }}
                                </td>
                                <td class="px-5 py-3">
                                    {{ $holiday->description }}
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this holiday?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-colors duration-150"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                                    No holidays have been added yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($holidays->hasPages())
                <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    {{ $holidays->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
