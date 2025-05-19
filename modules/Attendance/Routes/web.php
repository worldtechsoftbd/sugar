<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

use Modules\Attendance\Http\Controllers\AttendanceController;
use Modules\Attendance\Http\Controllers\DeviceAttendanceController;
use Modules\Attendance\Http\Controllers\EmployeeShiftController;
use Modules\Attendance\Http\Controllers\MillShiftController;
use Modules\Attendance\Http\Controllers\ShiftController;


Route::prefix('attendance')->group(function () {
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('/shifts/create', [ShiftController::class, 'create'])->name('shifts.create');
    Route::post('/shifts/store', [ShiftController::class, 'store'])->name('shifts.store');
    Route::get('/shifts/{id}/edit', [ShiftController::class, 'edit'])->name('shifts.edit'); // Changed to GET
    Route::put('/shifts/{id}', [ShiftController::class, 'update'])->name('shifts.update'); // Added for updating
    Route::delete('/shifts/{id}', [ShiftController::class, 'destroy'])->name('shifts.destroy');

    Route::get('/employee-shifts', [EmployeeShiftController::class, 'index'])->name('employee-shifts.index');
    Route::get('/employee-shifts/create', [EmployeeShiftController::class, 'create'])->name('employee-shifts.create');
    Route::post('/employee-shifts/store', [EmployeeShiftController::class, 'store'])->name('employee-shifts.store');
    Route::get('/employee-shifts/{id}/edit', [EmployeeShiftController::class, 'edit'])->name('employee-shifts.edit');
    Route::put('/employee-shifts/{id}', [EmployeeShiftController::class, 'update'])->name('employee-shifts.update');
    Route::delete('/employee-shifts/{id}', [EmployeeShiftController::class, 'destroy'])->name('employee-shifts.destroy');

    Route::get('/mill-shifts', [MillShiftController::class, 'index'])->name('attendance.mill-shifts.index');
    Route::get('/mill-shifts/create', [MillShiftController::class, 'create'])->name('attendance.mill-shifts.create');
    Route::post('/mill-shifts/store', [MillShiftController::class, 'store'])->name('attendance.mill-shifts.store');
    Route::get('/mill-shifts/{id}/edit', [MillShiftController::class, 'edit'])->name('attendance.mill-shifts.edit');
    Route::put('/mill-shifts/{id}', [MillShiftController::class, 'update'])->name('attendance.mill-shifts.update');
    Route::delete('/mill-shifts/{id}', [MillShiftController::class, 'destroy'])->name('attendance.mill-shifts.destroy');
// web.php
    Route::get('/get-offices/org/{organizationId}', [MillShiftController::class, 'getOffices'])->name('get.getOffices');

    Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.list.index');
    Route::get('attendances/data', [AttendanceController::class, 'getData'])->name('attendances.data');
    Route::get('device/attendances', [DeviceAttendanceController::class, 'index'])->name('device.attendances.list.index');
    Route::get('device/attendances/data', [DeviceAttendanceController::class, 'getData'])->name('device.attendances.data');

});
Route::get('/employees-by-organization', [EmployeeShiftController::class, 'getEmployeesByOrganization'])->name('getEmployeesByOrganization');
Route::get('/importUserInfo', [MillShiftController::class, 'importUserInfo'])->name('importUserInfo');


Route::get('/get-employee-departments', [EmployeeShiftController::class, 'getDepartments'])->name('get-employee-departments');
Route::get('/get-employee-Shifts', [EmployeeShiftController::class, 'getShifts'])->name('get-office-Shifts');
Route::get('/get-employee-offices', [EmployeeShiftController::class, 'getOffices'])->name('get-employee-offices');