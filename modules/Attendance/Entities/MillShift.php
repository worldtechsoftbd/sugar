<?php

namespace Modules\Attendance\Entities;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Department;
use Modules\HumanResource\Entities\Employee;
use Modules\Organization\App\Models\Organization;
use Modules\Organization\App\Models\OrganizationOffices;


class MillShift extends Model
{
    use SoftDeletes, BasicConfig;

    protected $fillable = [
        'mill_id',
//        'DepartmentId',
        'shift_id',
        'status',
        'MaxPerShift',
        'OnHoldPerShift',
        'IsApplicableConfig',
        'OverTimeYN',
        'MaxOverTime',
        'MinTime'
    ];

    protected $table = 'mill_shifts';

    protected $casts = [
        'OverTimeYN' => 'boolean',
        'MaxOverTime' => 'decimal:2',
        'MinTime' => 'decimal:2',
    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETED = 276;
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentId');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function Organization()
    {
        return $this->belongsTo(Organization::class, 'mill_id');
    }
    public function OrganizationOffices()
    {
        return $this->belongsTo(OrganizationOffices::class, 'mill_id');
    }
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


}

