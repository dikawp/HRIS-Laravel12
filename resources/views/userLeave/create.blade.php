@extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Apply for Leave
        </h2>

        <div class="max-w-2xl px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('my-leaves.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <p class="font-bold">Oops! Ada beberapa kesalahan pada input Anda:</p>
                        <ul class="list-disc ml-5 mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block text-sm md:col-span-2">
                        <span class="text-gray-700 dark:text-gray-400">Leave Type</span>
                        <select name="leave_type" class="block w-full mt-1 text-sm form-select" required>
                            <option value="0" @selected(old('leave_type') == 0)>Sakit</option>
                            <option value="1" @selected(old('leave_type') == 1)>Izin</option>
                            <option value="3" @selected(old('leave_type') == 3)>Lainnya</option>
                        </select>
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Start Date</span>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="block w-full mt-1 text-sm form-input" required>
                    </label>

                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">End Date</span>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="block w-full mt-1 text-sm form-input" required>
                    </label>

                    <label class="block text-sm md:col-span-2">
                        <span class="text-gray-700 dark:text-gray-400">Reason</span>
                        <textarea name="reason" class="block w-full mt-1 text-sm form-textarea" rows="3" required>{{ old('reason') }}</textarea>
                    </label>

                    <label class="block text-sm md:col-span-2">
                        <span class="text-gray-700 dark:text-gray-400">Attachment (Optional)</span>
                        <input type="file" name="attachment" class="block w-full mt-1 text-sm form-input">
                        <span class="text-xs text-gray-500">Allowed formats: jpg, png, pdf. Max size: 2MB.</span>
                    </label>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('my-leaves.index') }}" class="px-4 py-2 text-sm bg-gray-200 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 text-sm text-white bg-purple-600 rounded-lg">Submit
                        Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection
