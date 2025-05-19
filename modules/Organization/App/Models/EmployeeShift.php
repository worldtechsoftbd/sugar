<?php


namespace Modules\Organization\App\Models;

use App\Models\User;
use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResource\Entities\Employee;

class EmployeeShift extends Model
{
    use BasicConfig;
    protected $table = 'employee_shift';
    protected $primaryKey = 'EmployeeShiftID';
    public $timestamps = true;

    protected $fillable = [
        'CrShiftDetailID',
        'PrevShiftDetailID',
        'EmployeeID',
        'AssignedBy',
        'ShiftStatus',
        'Status',
        'OverTimeYN',
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
    ];

    const OVERTIME_YES = 'Y';
    const OVERTIME_NO = 'N';

    public function currentShiftDetail()
    {
        return $this->belongsTo(ShiftDetails::class, 'CrShiftDetailID', 'id');
    }

    public function previousShiftDetail()
    {
        return $this->belongsTo(ShiftDetails::class, 'PrevShiftDetailID', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'id');
    }

    public function assignedByUser()
    {
        return $this->belongsTo(User::class, 'AssignedBy', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}