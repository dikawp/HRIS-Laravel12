@extends('layouts.app')
@section('title', 'Department Lists')

@section('content')
    <div class="min-h-screen px-4 sm:px-6 py-6">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Departments
            </h1>
            <a href="{{ route('departments.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add New Department
            </a>
        </div>

        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Type to search department name or description..."
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Container for AJAX results --}}
        <div id="departmentDataContainer" class="bg-white dark:bg-gray-800/50 rounded-xl shadow-lg overflow-hidden">
            @include('hr.departments.department_table', ['departments' => $departments])
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const container = document.getElementById('departmentDataContainer');

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            const fetchData = async (url) => {
                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    container.innerHTML = await response.text();
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            };

            searchInput.addEventListener('input', debounce((e) => {
                const url = new URL('{{ route('departments.index') }}');
                url.searchParams.set('search', e.target.value);
                url.searchParams.set('page', 1);
                fetchData(url.toString());
            }, 400));

            // GABUNGKAN SEMUA EVENT LISTENER CLICK KE SATU FUNGSI
            document.body.addEventListener('click', function(e) {
                // Logika untuk Pagination
                if (e.target.matches('#departmentDataContainer .pagination a')) {
                    e.preventDefault();
                    const url = e.target.getAttribute('href');
                    if (url) {
                        fetchData(url);
                    }
                }

                // BARU: Logika untuk Expand/Collapse
                const toggleButton = e.target.closest('.details-toggle');
                if (toggleButton) {
                    const targetId = toggleButton.dataset.target;
                    const detailsRow = document.querySelector(targetId);
                    const expandIcon = toggleButton.querySelector('.expand-icon');
                    const collapseIcon = toggleButton.querySelector('.collapse-icon');

                    if (detailsRow) {
                        detailsRow.classList.toggle('hidden');
                        expandIcon.classList.toggle('hidden');
                        collapseIcon.classList.toggle('hidden');
                    }
                }
            });
        });
    </script>
@endpush
