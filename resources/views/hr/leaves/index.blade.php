@extends('layouts.app')

@section('title', 'Leave Management')

@section('content')

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Leave Management
    </h2>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card: Pending Leaves -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-warning-icon lucide-file-warning">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Pending Leaves</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $pendingCount }}</p>
            </div>
        </div>
        <!-- Card: On Leave Today -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-x2-icon lucide-calendar-x-2">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                    <path d="M3 10h18" />
                    <path d="m17 22 5-5" />
                    <path d="m17 17 5 5" />
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">On Leave Today</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $todayLeaves }}</p>
            </div>
        </div>
        <!-- Card: Approved This Month -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Approved This Month</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $approvedThisMonth }}</p>
            </div>
        </div>
        <!-- Card: Rejected This Month -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Rejected This Month</p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ $rejectedThisMonth }}</p>
            </div>
        </div>
    </div>

    <!-- Leave Table Container -->
    <div id="leaveRequestContainer" class="w-full overflow-hidden rounded-xl shadow-md bg-white dark:bg-gray-800">
        @include('hr.leaves.leave_table', ['leaveRequests' => $leaveRequests])
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('leaveRequestContainer');

            // Event delegation for toggling details on mobile
            container.addEventListener('click', function(e) {
                const toggleButton = e.target.closest('.details-toggle');
                if (!toggleButton) return;

                const targetId = toggleButton.dataset.target;
                const detailsRow = document.querySelector(targetId);

                if (detailsRow) {
                    const isHidden = detailsRow.classList.toggle('hidden');
                    toggleButton.querySelector('.expand-icon').classList.toggle('hidden', !isHidden);
                    toggleButton.querySelector('.collapse-icon').classList.toggle('hidden', isHidden);
                }
            });
        });
    </script>
@endpush
