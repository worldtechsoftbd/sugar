<?php

use Illuminate\Support\Facades\Route;
use Modules\Payroll\App\Http\Controllers\EmployeeSalaryController;
use Modules\Payroll\App\Http\Controllers\PayrollController;
use Modules\Payroll\App\Models\EmployeeSalary;

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

/*Route::group(['prefix' => 'salary-payroll', 'middleware' => ['auth']], function () {
    Route::resource('payroll', PayrollController::class)->names('payroll');
    Route::resource('employee-salary', EmployeeSalaryController::class)->names('employee-salary');

    Route::get('/payment-setup', [EmployeeSalaryController::class, 'paymentSetup'])->name('payroll.paymentSetup');
    Route::post('/payment-setup', [EmployeeSalaryController::class, 'storePaymentSetup'])->name('payroll.paymentSetup.store');



    // Routes in web.php
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/create', [PayrollController::class, 'createOrUpdate'])->name('payroll.create');
    Route::post('/payroll/store', [PayrollController::class, 'storeOrUpdate'])->name('payroll.store');
    Route::get('/payroll/edit/{id}', [PayrollController::class, 'createOrUpdate'])->name('payroll.edit');
    Route::post('/payroll/update/{id}', [PayrollController::class, 'storeOrUpdate'])->name('payroll.update');

});*/
Route::middleware(['auth'])->prefix('salary-payroll')->group(function () {

    // Payroll Routes
    Route::name('payroll.')->prefix('payroll')->controller(PayrollController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'createOrUpdate')->name('create');
        Route::post('/store', 'storeOrUpdate')->name('store');
        Route::get('/edit/{id}', 'createOrUpdate')->name('edit');
        Route::post('/update/{id}', 'storeOrUpdate')->name('update');

        Route::get('/day-count', 'dayCountIndex')->name('dayCount.index');
        Route::post('/day-count/process', 'processDayCount')->name('dayCount.process');
        Route::get('/day-count/list', 'listDayCount')->name('dayCount.list');
        Route::get('/day-count/edit/{id}',  'editDayCount')->name('dayCount.edit');
        Route::post('/day-count/update/{id}', 'updateDayCount')->name('dayCount.update');
    });

    // Employee Salary Routes (resource-like routes)
    Route::name('employee-salary.')->prefix('employee-salary')->controller(EmployeeSalaryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{employeeSalary}', 'show')->name('show');
        Route::get('/{employeeSalary}/edit', 'edit')->name('edit');
        Route::put('/{employeeSalary}', 'update')->name('update');
        Route::delete('/{employeeSalary}', 'destroy')->name('destroy');
    });

    // Payment Setup Routes (using payroll naming)
    Route::name('payroll.')->controller(EmployeeSalaryController::class)->group(function () {
        Route::get('/payment-setup', 'paymentSetup')->name('paymentSetup');
        Route::post('/payment-setup', 'storePaymentSetup')->name('paymentSetup.store');
    });

});
