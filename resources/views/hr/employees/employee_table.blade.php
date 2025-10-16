<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th scope="col" class="px-4 py-3 lg:hidden"><span class="sr-only">Expand</span></th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">No</th>
                <th scope="col" class="px-6 py-3 whitespace-nowrap">Full Name</th>
                <th scope="col" class="hidden px-6 py-3 whitespace-nowrap lg:table-cell">Email</th>
                <th scope="col" class="hidden px-6 py-3 whitespace-nowrap lg:table-cell">Department</th>
                <th scope="col" class="hidden px-6 py-3 whitespace-nowrap lg:table-cell">Position</th>
                <th scope="col" class="hidden px-6 py-3 whitespace-nowrap lg:table-cell">Hire Date</th>
                <th scope="col" class="hidden px-6 py-3 text-center whitespace-nowrap lg:table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
                {{-- Baris utama --}}
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600/50 transition-colors duration-150">
                    <td class="px-4 py-4 lg:hidden">
                        <button class="details-toggle" data-target="#details-{{ $employee->id }}">
                            <svg class="w-5 h-5 expand-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <svg class="w-5 h-5 collapse-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $employees->firstItem() + $loop->index }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $employee->full_name }}</td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ $employee->user->email }}</td>
                    <td class="hidden px-6 py-4 lg:table-cell"><span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">{{ $employee->department->name }}</span></td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ $employee->position->name }}</td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') }}</td>
                    <td class="hidden px-6 py-4 text-center lg:table-cell">
                        <div class="flex justify-center items-center space-x-4">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Baris detail (collapsible) --}}
                <tr id="details-{{ $employee->id }}" class="hidden border-b dark:border-gray-700 lg:hidden">
                    <td colspan="3" class="p-4 bg-gray-50 dark:bg-gray-800/50">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="flex flex-col"><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Email</span><span>{{ $employee->user->email }}</span></div>
                            <div class="flex flex-col"><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Department</span><span>{{ $employee->department->name }}</span></div>
                            <div class="flex flex-col"><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Position</span><span>{{ $employee->position->name }}</span></div>
                            <div class="flex flex-col"><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Hire Date</span><span>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') }}</span></div>
                            <div class="flex flex-col sm:col-span-2"><span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Actions</span>
                                <div class="flex items-center mt-1 space-x-4">
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        No employees found matching your criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Link Pagination --}}
<div class="p-4 border-t border-gray-200 dark:border-gray-700">
    {{ $employees->links() }}
</div>
