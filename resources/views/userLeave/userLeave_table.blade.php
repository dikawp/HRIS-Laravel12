<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
            <tr>
                <th scope="col" class="px-4 py-3 lg:hidden"><span class="sr-only">Expand</span></th>
                <th class="px-6 py-3 font-semibold">Status</th>
                <th class="hidden px-6 py-3 font-semibold lg:table-cell">Date</th>
                <th class="hidden px-6 py-3 font-semibold lg:table-cell">Reason</th>
                <th class="hidden px-6 py-3 font-semibold text-center lg:table-cell">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($myRequests as $request)
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
                    <td class="px-6 py-4"><span
                            class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="hidden px-6 py-4 whitespace-nowrap lg:table-cell">
                        {{ $request->start_date->format('d M Y') }} – {{ $request->end_date->format('d M Y') }}</td>
                    <td class="hidden px-6 py-4 lg:table-cell">{{ Str::limit($request->reason, 35) }}</td>
                    <td class="hidden px-6 py-4 text-center lg:table-cell">
                        @if ($request->status == 0)
                            {{-- Hanya tampil jika status Pending --}}
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{ route('my-leaves.edit', $request->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('my-leaves.destroy', $request->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>

                {{-- Collapsible Details Row --}}
                <tr id="details-{{ $request->id }}" class="hidden border-b dark:border-gray-700 lg:hidden">
                    <td colspan="3" class="p-4 bg-gray-50 dark:bg-gray-800/50">
                        <div class="grid grid-cols-1 gap-y-4">
                            <div>
                                <span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Date</span>
                                <p class="text-gray-800 dark:text-gray-200">{{ $request->start_date->format('d M Y') }}
                                    to {{ $request->end_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <span class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Reason</span>
                                <p class="text-gray-800 dark:text-gray-200">{{ $request->reason }}</p>
                            </div>
                            @if ($request->status == 2 && $request->rejection_reason)
                                <div class="pt-4 border-t dark:border-gray-600"><span
                                        class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Reason for
                                        Rejection</span>
                                    <p class="text-red-600 dark:text-red-400">{{ $request->rejection_reason }}</p>
                                </div>
                            @endif

                            {{-- Actions for Mobile View --}}
                            @if ($request->status == 0)
                                <div class="flex flex-col sm:col-span-2 pt-4 border-t dark:border-gray-600">
                                    <span
                                        class="font-bold text-xs uppercase text-gray-500 dark:text-gray-400">Actions</span>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <a href="{{ route('my-leaves.edit', $request->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('my-leaves.destroy', $request->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this request?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">You haven't
                        submitted any leave requests yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
