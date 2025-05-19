<?php

namespace Modules\Attendance\Entities;

use App\Models\User;
use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Employee;

class EmployeeShift extends Model
{
    use BasicConfig,softDeletes ;

    protected $table = 'employee_shifts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'employee_id',
        'mill_shift_id',
        'uuid',
        'shift_date',
        'shiftStartDate',
        'shiftEndDate',
        'isShiftStartEndApplicable',
        'CrShiftDetailID',
        'PrevShiftDetailID',
        'AssignedBy',
        'ShiftStatus',
        'Status',
        'OverTimeYN',
        'OverTimeHours',
        'Created_At',
        'Updated_At',
        'Deleted_At'
    ];

    const STATUS_ASSIGNED = 1;
    const STATUS_UNASSIGNED = 2;
    const STATUS_DELETED = 276;

    const SHIFT_STATUS_INITIAL = 101;
    const SHIFT_STATUS_APPROVED = 201;
    const SHIFT_STATUS_SINGLE_TRANSFER = 301;
    const SHIFT_STATUS_SHIFT_ROTATION = 401;
    const SHIFT_STATUS_SHIFT_MERGING = 501;
    const SHIFT_STATUS_INACTIVE = 128;

    protected $casts = [
        'Created_At' => 'datetime',
        'Updated_At' => 'datetime',
        'Deleted_At' => 'datetime',
        'OverTimeYN' => 'boolean',
        'isShiftStartEndApplicable' => 'boolean',
    ];

    const OVERTIME_YES = 'Y';
    const OVERTIME_NO = 'N';


    public function currentShiftDetail()
    {
        return $this->belongsTo(MillShift::class, 'CrShiftDetailID', 'id');
    }
    public function organization()
    {
        return $this->belongsTo(MillShift::class, 'CrShiftDetailID', 'id');
    }

    public function previousShiftDetail()
    {
        return $this->belongsTo(MillShift::class, 'PrevShiftDetailID', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function employees()
    {
        return $this->belongsToMany(
            Employee::class, // The related model
            'employee_shifts', // The pivot table name
            'employee_shift_id', // Foreign key for EmployeeShift in the pivot table
            'employee_id' // Foreign key for Employee in the pivot table
        );
    }
    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'AssignedBy', 'id');
    }

//    public function millShift()
//    {
//        return $this->belongsTo(MillShift::class);
//    }

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

    public function delete()
    {
        $this->update([
            'status' => self::STATUS_DELETED,
            'deleted_at' => now(),
        ]);

        // Call the parent's delete method to handle soft delete properly.
        parent::delete();
    }

    public function millShift()
    {
        return $this->belongsTo(MillShift::class, 'mill_shift_id', 'id');
    }


}

