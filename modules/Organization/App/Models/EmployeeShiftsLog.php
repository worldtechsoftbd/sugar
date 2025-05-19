<?php

namespace App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;

class EmployeeShiftsLog extends Model
{
    use BasicConfig;
    protected $table = 'employee_shifts_logs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'EmployeeShiftID',
        'CrShiftDetailID',
        'PrevShiftDetailID',
        'EmployeeID',
        'AssignedBy',
        'ShiftStatus',
        'OverTimeYN',
        'Status',
        'Created_At',
        'Updated_At',
        'Logged_At'
    ];

    protected $casts = [
        'Created_At' => 'datetime',
        'Updated_At' => 'datetime',
        'Logged_At' => 'datetime',
    ];

    // Inside the EmployeeShift model
    protected static function boot()
    {
        parent::boot();

        // Other boot configurations
        static::bootBasicConfigs();

        static::updating(function ($employeeShift) {
            EmployeeShiftsLog::create([
                'EmployeeShiftID' => $employeeShift->EmployeeShiftID,
                'CrShiftDetailID' => $employeeShift->CrShiftDetailID,
                'PrevShiftDetailID' => $employeeShift->PrevShiftDetailID,
                'EmployeeID' => $employeeShift->EmployeeID,
                'OverTimeYN' => $employeeShift->OverTimeYN,
                'AssignedBy' => $employeeShift->AssignedBy,
                'ShiftStatus' => $employeeShift->ShiftStatus,
                'Status' => $employeeShift->Status,
                'Created_At' => $employeeShift->Created_At,
                'Updated_At' => $employeeShift->Updated_At,
                'Logged_At' => now(),
            ]);
        });
    }



}