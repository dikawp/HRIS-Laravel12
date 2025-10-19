@extends('layouts.app')

@section('title', 'My Leave History')

@section('content')
    <div class="container mx-auto grid">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center my-6 gap-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">My Leave History</h2>
            <a href="{{ route('my-leaves.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg shadow hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Apply for Leave
            </a>
        </div>

        <!-- Leave Table Container -->
        <div id="leaveDataContainer" class="w-full overflow-hidden rounded-xl shadow-md bg-white dark:bg-gray-800">
            @include('userLeave.userLeave_table', ['myRequests' => $myRequests])
        </div>

        <!-- Pagination (jika tidak ada di dalam table partial) -->
        <div class="mt-4">
            {{ $myRequests->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('leaveDataContainer');

            // Event delegation for toggling details on mobile
            container.addEventListener('click', function(e) {
                const toggleButton = e.target.closest('.details-toggle');

                if (!toggleButton) return;

                const targetId = toggleButton.dataset.target;
                const detailsRow = document.querySelector(targetId);

                if (detailsRow) {
                    const isHidden = detailsRow.classList.toggle('hidden');

                    // Toggle icons
                    toggleButton.querySelector('.expand-icon').classList.toggle('hidden', !isHidden);
                    toggleButton.querySelector('.collapse-icon').classList.toggle('hidden', isHidden);
                }
            });
        });
    </script>
@endpush
