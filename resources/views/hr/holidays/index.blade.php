@extends('layouts.app')

@section('content')
    <div class="container mx-auto grid">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Manage Holidays
            </h2>
            <button id="addHolidayBtn"
                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                + Add New Holiday
            </button>
        </div>

        <div class="p-4 mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-md">
            <form action="{{ route('holidays.index') }}" method="GET"
                class="md:flex md:items-center md:gap-4 space-y-3 md:space-y-0">
                <div>
                    <label for="year" class="sr-only">Filter by Year</label>
                    <select name="year" id="year" onchange="this.form.submit()"
                        class="w-full md:w-auto text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>All Years</option>
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" id="search" placeholder="Search by description..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500">
                </div>
            </form>
        </div>

        @forelse ($holidaysByMonth as $month => $holidays)
            <div class="mb-8">
                <h3 class="mb-3 text-lg font-semibold text-gray-600 dark:text-gray-300">{{ $month }}</h3>
                <div class="w-full overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-md">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($holidays as $holiday)
                                    <tr
                                        class="text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                        <td class="px-5 py-4 w-1/3">
                                            <p class="font-semibold">
                                                {{ \Carbon\Carbon::parse($holiday->date)->format('d F Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($holiday->date)->format('l') }}</p>
                                        </td>
                                        <td class="px-5 py-4">{{ $holiday->description }}</td>
                                        <td class="px-5 py-4 text-right">
                                            <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-500 rounded-full transition-colors"
                                                    title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="w-full text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-md">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">No holidays found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No holidays match your current filters.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal Input --}}
    <div id="holidayModal" class="hidden fixed inset-0 z-30 items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4" id="modalContent">
            <div class="flex justify-between items-center border-b pb-3 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Add New Holiday</h3>
                <button id="closeModalBtn" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('holidays.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label for="date"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" required class="w-full text-sm rounded-lg ...">
                    @error('date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <input type="text" name="description" placeholder="e.g., New Year's Day" required
                        class="w-full text-sm rounded-lg ...">
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" id="cancelBtn"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 ...">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 ...">Save
                        Holiday</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addHolidayBtn = document.getElementById('addHolidayBtn');
            const holidayModal = document.getElementById('holidayModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const modalContent = document.getElementById('modalContent');

            const openModal = () => {
                holidayModal.classList.remove('hidden');
                holidayModal.classList.add('flex');
            };
            const closeModal = () => {
                holidayModal.classList.add('hidden');
                holidayModal.classList.remove('flex');
            };

            addHolidayBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            holidayModal.addEventListener('click', function(event) {
                if (!modalContent.contains(event.target) && holidayModal.contains(event.target)) {
                    closeModal();
                }
            });
        });
    </script>
@endpush
