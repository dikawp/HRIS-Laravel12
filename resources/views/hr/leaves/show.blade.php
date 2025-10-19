@extends('layouts.app')

@section('content')
    {{-- Main container with Alpine.js data for modal control --}}
    <div class="container px-6 mx-auto grid" x-data="{ isModalOpen: false }">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Leave Request Details
        </h2>

        <div class="px-4 py-5 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm text-gray-700 dark:text-gray-300">
                <div>
                    <span class="font-semibold">Employee:</span>
                    <p>{{ $leaveRequest->employee->full_name }}</p>
                </div>
                <div>
                    <span class="font-semibold">Department:</span>
                    <p>{{ $leaveRequest->employee->department->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="font-semibold">Leave Type:</span>
                    <p>
                        @if ($leaveRequest->leave_type == 0)
                            Sakit
                        @elseif($leaveRequest->leave_type == 1)
                            Izin
                        @else
                            Lainnya
                        @endif
                    </p>
                </div>
                <div>
                    <span class="font-semibold">Status:</span>
                    <p>
                        @if ($leaveRequest->status == 0)
                            Pending
                        @elseif($leaveRequest->status == 1)
                            Approved
                        @else
                            Rejected
                        @endif
                    </p>
                </div>
                <div>
                    <span class="font-semibold">Start Date:</span>
                    <p>{{ $leaveRequest->start_date->format('d F Y, l') }}</p>
                </div>
                <div>
                    <span class="font-semibold">End Date:</span>
                    <p>{{ $leaveRequest->end_date->format('d F Y, l') }}</p>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <span class="font-semibold">Reason:</span>
                    <p class="mt-1">{{ $leaveRequest->reason }}</p>
                </div>
                @if ($leaveRequest->attachment)
                    <div class="col-span-1 md:col-span-2">
                        <span class="font-semibold">Attachment:</span>
                        <p class="mt-1"><a href="{{ Storage::url($leaveRequest->attachment) }}" target="_blank"
                                class="text-purple-600 hover:underline">View Attachment</a></p>
                    </div>
                @endif
            </div>

            @if ($leaveRequest->status == 0)
                <div class="flex justify-end mt-6 space-x-4 border-t dark:border-gray-700 pt-4">
                    <button @click="isModalOpen = true"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                        Reject
                    </button>
                    <form action="{{ route('leaves.update', $leaveRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="approve">
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                            Approve
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
            x-transition:leave="transition ease-in duration-150"
            class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <div @click.away="isModalOpen = false"
                class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl">
                <form action="{{ route('leaves.update', $leaveRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="reject">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Reject Leave Request</h3>
                    <div class="mt-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Reason for Rejection</span>
                            <textarea name="rejection_reason" class="block w-full mt-1 text-sm form-textarea" rows="3"
                                placeholder="Enter reason here..."></textarea>
                        </label>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" name="no_reason" class="form-checkbox">
                            <span class="ml-2 text-sm">No specific reason</span>
                        </label>
                    </div>
                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" @click="isModalOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Confirm Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
