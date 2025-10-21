{{-- Container untuk Tabel dan Paginasi --}}
<div class="w-full overflow-hidden rounded-xl shadow-md bg-white dark:bg-gray-800">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    {{-- Kolom expand/collapse untuk mobile --}}
                    <th scope="col" class="px-4 py-3 lg:hidden"><span class="sr-only">Expand</span></th>

                    {{-- Kolom yang selalu terlihat --}}
                    <th class="px-6 py-3 font-semibold">Date</th>
                    <th class="px-6 py-3 font-semibold">Work Hours</th>

                    {{-- Kolom yang hanya terlihat di desktop --}}
                    <th class="hidden px-6 py-3 font-semibold lg:table-cell">Check In</th>
                    <th class="hidden px-6 py-3 font-semibold lg:table-cell">Check Out</th>
                    <th class="hidden px-6 py-3 font-semibold text-center lg:table-cell">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($attendanceHistory as $log)
                    {{-- Baris Utama (Main Row) --}}
                    <tr
                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors duration-150">
                        {{-- Tombol Toggle Mobile --}}
                        <td class="px-4 py-4 lg:hidden">
                            <button class="details-toggle" data-target="#details-{{ $log->id }}">
                                <svg class="w-5 h-5 expand-icon" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                <svg class="w-5 h-5 collapse-icon hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </td>

                        {{-- Data yang Selalu Terlihat --}}
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($log->date)->format('d M Y, l') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold">{{ $log->work_hours ?? 'N/A' }}</span>
                        </td>

                        {{-- Data yang Hanya Terlihat di Desktop --}}
                        <td class="hidden px-6 py-4 lg:table-cell">
                            {{ $log->check_in ? \Carbon\Carbon::parse($log->check_in)->format('H:i') : '-' }}
                        </td>
                        <td class="hidden px-6 py-4 lg:table-cell">
                            {{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('H:i') : '-' }}
                        </td>
                        <td class="hidden px-6 py-4 text-center lg:table-cell">
                            <a href="{{ route('attendances.edit', $log->id) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Edit
                            </a>
                        </td>
                    </tr>

                    {{-- Baris Detail (Collapsible Details Row) untuk Mobile --}}
                    <tr id="details-{{ $log->id }}" class="hidden border-b dark:border-gray-700 lg:hidden">
                        <td colspan="3" class="p-4 bg-gray-50 dark:bg-gray-800/50">
                            <div class="grid grid-cols-1 gap-y-4">
                                <div>
                                    <span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Check
                                        In</span>
                                    <p class="text-gray-800 dark:text-gray-200">
                                        {{ $log->check_in ? \Carbon\Carbon::parse($log->check_in)->format('H:i:s') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Check
                                        Out</span>
                                    <p class="text-gray-800 dark:text-gray-200">
                                        {{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('H:i:s') : '-' }}
                                    </p>
                                </div>
                                <div class="pt-4 border-t dark:border-gray-600">
                                    <span
                                        class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Action</span>
                                    <div class="mt-2">
                                        <a href="{{ route('attendances.edit', $log->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            No attendance history found for this employee.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($attendanceHistory && $attendanceHistory->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $attendanceHistory->withQueryString()->links() }}
        </div>
    @endif
</div>
