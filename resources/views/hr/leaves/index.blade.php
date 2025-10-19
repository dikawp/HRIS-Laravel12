@extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Leave Management
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Pending Leaves</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $pendingCount }}</p>
            </div>
            <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">On Leave Today</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $todayLeaves }}</p>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-md">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Employee Name</th>
                            <th class="px-4 py-3">Leave Type</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($leaveRequests as $request)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $request->employee->full_name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $request->employee->position->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{-- Menggunakan accessor yang sudah kita buat di model --}}
                                    {{ $request->leave_type_text }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $request->start_date->format('d M Y') }} - {{ $request->end_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    {{-- Logika untuk menampilkan badge status berdasarkan angka --}}
                                    @if ($request->status == 0)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">Pending</span>
                                    @elseif($request->status == 1)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Approved</span>
                                    @elseif($request->status == 2)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('leaves.show', $request->id) }}"
                                        class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                {{ $leaveRequests->links() }}
            </div>
        </div>
    </div>
@endsection
