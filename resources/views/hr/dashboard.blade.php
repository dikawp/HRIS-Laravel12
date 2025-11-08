@extends('layouts.app')
@section('title', 'HR Dashboard')
@section('content')
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">

        <!-- Dashboard Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome back, [User Name]! Here is a summary of today's
                activities.</p>
        </div>

        <!-- Statistics Summary (KPI Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1: Total Employees -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.25 0m-5.25 0a3.75 3.75 0 00-5.25 0M12 19.5a3 3 0 01-3-3V12a3 3 0 013-3h.008c1.657 0 3 1.343 3 3v4.5a3 3 0 01-3 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">1,250</p>
                </div>
            </div>

            <!-- Card 2: Active Employees -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-300" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Active Employees</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">1,215</p>
                </div>
            </div>

            <!-- Card 3: On Leave Today -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-300" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">On Leave Today</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">12</p>
                </div>
            </div>

            <!-- Card 4: Pending Approvals -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-500 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pending Approvals</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">5</p>
                </div>
            </div>
        </div>

        <!-- Main Content (2 columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Announcements & Employee List -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Company Announcements -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Company Announcements</h3>
                    <div class="space-y-4">
                        <!-- Announcement Item 1 -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-l-4 border-blue-500">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">HRIS System Maintenance</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">The system will be down on
                                Saturday, Oct 28, 2025 from 10:00 PM to 11:00 PM.</p>
                        </div>
                        <!-- Announcement Item 2 -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border-l-4 border-green-500">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Q4 Town Hall Event</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Don't forget to attend the Q4 Town
                                Hall event on Friday, Oct 27, 2025 in the auditorium.</p>
                        </div>
                    </div>
                </div>

                <!-- Leave Request List -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Latest Leave Requests</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Employee Name</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Leave Type</th>
                                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Row 1 -->
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Budi Santoso</td>
                                    <td class="px-6 py-4">Oct 25 - Oct 26, 2025</td>
                                    <td class="px-6 py-4">Annual Leave</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View
                                            Details</a>
                                    </td>
                                </tr>
                                <!-- Data Row 2 -->
                                <tr
                                    class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Citra Lestari</td>
                                    <td class="px-6 py-4">Oct 27, 2025</td>
                                    <td class="px-6 py-4">Sick Leave</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View
                                            Details</a>
                                    </td>
                                </tr>
                                <!-- Data Row 3 -->
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Agung Wijaya</td>
                                    <td class="px-6 py-4">Oct 30, 2025</td>
                                    <td class="px-6 py-4">Annual Leave</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View
                                            Details</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Birthdays & Holidays -->
            <div class="space-y-8">
                <!-- Employee Birthdays -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Birthdays This Week</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3">
                            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?u=a042581f4e29026704d"
                                alt="Profile Picture">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Dian Pratiwi</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">October 25 (Today)</p>
                            </div>
                        </li>
                        <li class="flex items-center space-x-3">
                            <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?u=a042581f4e29026705d"
                                alt="Profile Picture">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Rahmat Hidayat</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">October 27</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Upcoming Holidays -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Upcoming Holidays</h3>
                    <ul class="space-y-3">
                        <li class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-700 dark:text-gray-200">Heroes' Day</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">National</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 dark:text-white">Nov 10, 2025</span>
                        </li>
                        <li class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-700 dark:text-gray-200">Christmas Day</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">National</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 dark:text-white">Dec 25, 2025</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
