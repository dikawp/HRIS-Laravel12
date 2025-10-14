@extends('layouts.app')
@section('title', 'Employee Lists')

@section('content')
    <div class="min-h-screen py-6 px-4 sm:px-6">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Employee List
            </h1>
            <a href="{{ route('employees.create') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add New Employee
            </a>
        </div>

        {{-- Form Pencarian  --}}
        <div class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            {{-- Search Input --}}
            <div class="md:col-span-3">
                <label for="searchInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                <input type="text" id="searchInput" placeholder="Search by name or email..."
                    class="mt-1 w-full px-4 py-2 border rounded-lg dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">
            </div>

            {{-- Department --}}
            <div>
                <label for="departmentFilter"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                <select id="departmentFilter"
                    class="mt-1 w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-gray-300">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ request('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Position --}}
            <div>
                <label for="positionFilter"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                <select id="positionFilter" disabled
                    class="mt-1 w-full px-4 py-2 border rounded-lg dark:text-gray-300 disabled:bg-gray-200 dark:disabled:bg-gray-700 dark:bg-gray-800 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Department First</option>
                </select>
            </div>
        </div>

        <div id="employeeDataContainer" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @include('hr.employees.employee_table', ['employees' => $employees])
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const departmentFilter = document.getElementById('departmentFilter');
            const positionFilter = document.getElementById('positionFilter');
            const container = document.getElementById('employeeDataContainer');

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            function buildUrlAndFetch() {
                const url = new URL('{{ route('employees.index') }}');
                url.searchParams.set('search', searchInput.value);
                url.searchParams.set('department_id', departmentFilter.value);
                url.searchParams.set('position_id', positionFilter.value);
                url.searchParams.set('page', 1);
                fetchData(url.toString());
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

            const updatePositionFilter = async () => {
                const departmentId = departmentFilter.value;
                positionFilter.innerHTML = '<option value="">Loading...</option>';
                positionFilter.disabled = true;

                if (!departmentId) {
                    positionFilter.innerHTML = '<option value="">Select Department First</option>';
                    return;
                }

                try {
                    const response = await fetch(`/departments/${departmentId}/positions`);
                    const positions = await response.json();

                    positionFilter.innerHTML = '<option value="">All Positions</option>';
                    positions.forEach(position => {
                        const option = document.createElement('option');
                        option.value = position.id;
                        option.textContent = position.name;
                        positionFilter.appendChild(option);
                    });
                    positionFilter.disabled = false;
                } catch (error) {
                    console.error('Error fetching positions:', error);
                    positionFilter.innerHTML = '<option value="">Failed to load</option>';
                }
            };

            searchInput.addEventListener('input', debounce(buildUrlAndFetch, 400));

            departmentFilter.addEventListener('change', async function() {
                await updatePositionFilter();
                buildUrlAndFetch();
            });

            positionFilter.addEventListener('change', buildUrlAndFetch);

            document.body.addEventListener('click', function(e) {
                if (e.target.matches('#employeeDataContainer .pagination a')) {
                    e.preventDefault();
                    fetchData(e.target.getAttribute('href'));
                }
            });

            if (departmentFilter.value) {
                updatePositionFilter().then(() => {
                    const selectedPosition = '{{ request('position_id') }}';
                    if (selectedPosition) {
                        positionFilter.value = selectedPosition;
                    }
                });
            }
        });
    </script>
@endpush
