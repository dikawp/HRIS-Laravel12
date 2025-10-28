<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-4 py-3 lg:hidden"><span class="sr-only">Expand</span></th>
                <th class="px-6 py-3 font-semibold">Employee</th>
                <th class="px-6 py-3 font-semibold">Status</th>
                <th class="hidden px-6 py-3 font-semibold lg:table-cell">Department</th>
                <th class="hidden px-6 py-3 font-semibold lg:table-cell">Date</th>
                <th class="hidden px-6 py-3 font-semibold text-center lg:table-cell">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($leaveRequests as $request)
                {{-- Main Row --}}
                <tr
                    class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors duration-150">
                    <td class="px-4 py-4 lg:hidden">
                        <button class="details-toggle" data-target="#details-{{ $request->id }}">
                            <svg class="w-5 h-5 expand-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                            <svg class="w-5 h-5 collapse-icon hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                        <p class="font-semibold">{{ $request->employee->full_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $request->employee->position->name }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ $request->employee->department->name }}</td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ $leaveType }}</td>
                    <td class="hidden px-6 py-4 whitespace-nowrap lg:table-cell">
                        {{ $request->start_date->format('d M Y') }} – {{ $request->end_date->format('d M Y') }}</td>
                    <td class="hidden px-6 py-4 text-center lg:table-cell">
                        <a href="{{ route('leaves.show', $request->id) }}"
                            class="font-medium text-purple-600 dark:text-purple-500 hover:underline">View Details</a>
                    </td>
                </tr>

                {{-- Collapsible Details Row --}}
                <tr id="details-{{ $request->id }}" class="hidden border-b dark:border-gray-700 lg:hidden">
                    <td colspan="3" class="p-4 bg-gray-50 dark:bg-gray-800/50">
                        <div class="grid grid-cols-1 gap-y-4">
                            <div><span
                                    class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Department</span>
                                <p class="text-gray-800 dark:text-gray-200">{{ $request->employee->department->name }}
                                </p>
                            </div>
                            <div><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Date</span>
                                <p class="text-gray-800 dark:text-gray-200">{{ $request->start_date->format('d M Y') }}
                                    to {{ $request->end_date->format('d M Y') }}</p>
                            </div>
                            <div class="pt-4 border-t dark:border-gray-600">
                                <span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Action</span>
                                <div class="mt-2">
                                    <a href="{{ route('leaves.show', $request->id) }}"
                                        class="font-medium text-purple-600 dark:text-purple-500 hover:underline">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">No leave requests
                        found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination Links --}}
<div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
    {{ $leaveRequests->links() }}
</div>
