<?php

use App\Http\Controllers\HR\AttendanceController;
use App\Http\Controllers\HR\DashboardController;
use App\Http\Controllers\HR\DepartmentController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Attendance
    Route::get('/my-attendance', [UserAttendanceController::class, 'index'])->name('my.attendance.index');
    Route::post('/my-attendance/check-in', [UserAttendanceController::class, 'checkIn'])->name('my.attendance.checkin');
    Route::post('/my-attendance/check-out', [UserAttendanceController::class, 'checkOut'])->name('my.attendance.checkout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/hr/dashboard', [DashboardController::class, 'index'])->name('hr.dashboard');

    // Departments
    Route::resource('departments', DepartmentController::class);
    Route::get('/departments/{department}/positions', [DepartmentController::class, 'getPositions'])->name('departments.positions');

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Attendance
    Route::resource('attendances', AttendanceController::class);
});


require __DIR__ . '/auth.php';
