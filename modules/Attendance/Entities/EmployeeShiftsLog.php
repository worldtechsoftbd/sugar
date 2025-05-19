<?php

namespace Modules\Attendance\Entities;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;

class EmployeeShiftsLog extends Model
{
    use BasicConfig;

    protected $table = 'employee_shift_logs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'EmployeeShiftID',
        'mill_shift_id',
        'uuid',
        'shiftStartDate',
        'shiftEndDate',
        'isShiftStartEndApplicable',
        'CrShiftDetailID',
        'PrevShiftDetailID',
        'EmployeeID',
        'AssignedBy',
        'ShiftStatus',
        'Status',
        'OverTimeYN',
        'OverTimeHours',
        'created_at',
        'updated_at',
        'Logged_At'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'Logged_At' => 'datetime',
        'OverTimeYN' => 'boolean',
        'isShiftStartEndApplicable' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($employeeShift) {
            EmployeeShiftsLog::create([
                'EmployeeShiftID' => $employeeShift->id,
                'mill_shift_id' => $employeeShift->mill_shift_id,
                'uuid' => $employeeShift->uuid,
                'shiftStartDate' => $employeeShift->shiftStartDate,
                'shiftEndDate' => $employeeShift->shiftEndDate,
                'isShiftStartEndApplicable' => $employeeShift->isShiftStartEndApplicable,
                'CrShiftDetailID' => $employeeShift->CrShiftDetailID,
                'PrevShiftDetailID' => $employeeShift->PrevShiftDetailID,
                'EmployeeID' => $employeeShift->EmployeeID,
                'AssignedBy' => $employeeShift->AssignedBy,
                'ShiftStatus' => $employeeShift->ShiftStatus,
                'Status' => $employeeShift->Status,
                'OverTimeYN' => $employeeShift->OverTimeYN,
                'OverTimeHours' => $employeeShift->OverTimeHours,
                'Created_At' => $employeeShift->Created_At,
                'Updated_At' => $employeeShift->Updated_At,
                'Logged_At' => now(),
            ]);
        });
    }
}