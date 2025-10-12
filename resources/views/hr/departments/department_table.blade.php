<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700/50">
            <tr>
                {{-- Kolom header untuk tombol expander, hanya muncul di mobile --}}
                <th scope="col" class="px-4 py-3 lg:hidden"><span class="sr-only">Expand</span></th>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Department Name</th>
                {{-- Kolom ini akan disembunyikan di mobile --}}
                <th scope="col" class="hidden px-6 py-3 lg:table-cell">Description</th>
                <th scope="col" class="hidden px-6 py-3 lg:table-cell text-center">Total Positions</th>
                <th scope="col" class="hidden px-6 py-3 text-center lg:table-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($departments as $department)
                {{-- Baris utama yang selalu terlihat --}}
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600/50">
                    {{-- Tombol expander untuk mobile --}}
                    <td class="px-4 py-4 lg:hidden">
                        <button class="details-toggle" data-target="#details-{{ $department->id }}">
                            <svg class="w-5 h-5 expand-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <svg class="w-5 h-5 collapse-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $departments->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $department->name }}
                    </td>
                    {{-- Data ini disembunyikan di mobile dan hanya muncul di desktop --}}
                    <td class="hidden px-6 py-4 lg:table-cell">
                        {{ Str::limit($department->description, 50) }}
                    </td>
                    <td class="hidden px-6 py-4 text-center lg:table-cell">
                        {{ $department->positions_count }}
                    </td>
                    <td class="hidden px-6 py-4 lg:table-cell">
                        <div class="flex justify-center items-center space-x-4">
                            <a href="{{ route('departments.edit', $department->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Baris detail (collapsible), hanya muncul di mobile setelah di-klik --}}
                <tr id="details-{{ $department->id }}" class="hidden border-b dark:border-gray-700 lg:hidden">
                    <td colspan="3" class="p-4 bg-gray-50 dark:bg-gray-800/50">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <h4 class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Description</h4>
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $department->description ?? '-' }}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Total Positions</h4>
                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $department->positions_count }}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Actions</h4>
                                <div class="flex items-center space-x-4 mt-1">
                                    <a href="{{ route('departments.edit', $department->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                    No departments found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="p-4 border-t border-gray-200 dark:border-gray-700">
    {{ $departments->links() }}
</div>
