<?php

use Illuminate\Support\Facades\Route;
use Modules\Organization\App\Http\Controllers\OrganizationController;
use Modules\Organization\App\Http\Controllers\OrganizationDepartmentController;
use Modules\Organization\App\Http\Controllers\OrganizationOfficeController;
use Modules\Organization\App\Http\Controllers\OrganizationOfficeDetailsController;
use Modules\Organization\App\Http\Controllers\OrgOfficeHeadController;
use Modules\Organization\App\Http\Controllers\ShiftMasterController;

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

Route::group([], function () {
    Route::resource('organizations', OrganizationController::class);
    Route::resource('organization_offices', OrganizationOfficeController::class);
    Route::resource('organization_offices_details', OrganizationOfficeDetailsController::class);
    Route::resource('organization-departments', OrganizationDepartmentController::class);


    Route::get('/organization_offices/get_offices_by_org', [OrganizationOfficeDetailsController::class, 'getOfficesByOrg'])->name('organization_offices.get_offices_by_org');
});

Route::group(['prefix' => 'organization-head', 'as' => 'organization-head.'], function () {
    Route::get('/', [OrgOfficeHeadController::class,'index'])->name('orgOfficeHead.index');
    Route::get('/createOrEdit', [OrgOfficeHeadController::class,'createOrEdit'])->name('orgOfficeHead.createOrEdit');
});



Route::get('/load-office-details-hierarchy', [OrganizationDepartmentController::class, 'loadDepartmentHierarchy'])->name('loadDepartmentHierarchy');


Route::get('/organizationOfficeTypes/{organizationId}', [OrganizationDepartmentController::class, 'getOrganizationOfficesByOrganizationId'])->name('organization_offices.get_offices_by_org_id');
Route::get('/organizationOfficeParentDepartments/{organizationId}', [OrganizationDepartmentController::class, 'getParentDepartmentsByOrganizationId'])->name('organization_offices.organizationOfficeDepartments');

Route::resource('shiftMasters', ShiftMasterController::class)->names('shiftMasters');
/*Route::get('shift-masters', [ShiftMasterController::class, 'index'])->name('shiftMasters.index');*/
Route::get('shift-masters/data', [ShiftMasterController::class, 'getData'])->name('shiftMasters.data');
