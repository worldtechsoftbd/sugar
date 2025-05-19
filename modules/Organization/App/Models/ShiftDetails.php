<?php

namespace Modules\Organization\App\Models;


use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\HumanResource\Entities\Department;

class ShiftDetails extends Model
{
    use HasFactory, SoftDeletes,BasicConfig;

    protected $table = 'shift_details';

    protected $primaryKey = 'id';


    protected $fillable = [
        'ShiftID',
        'DepartmentId',
        'MaxPerShift',
        'OnHoldPerShift',
        'IsApplicableConfig',
        'OverTimeYN', // It will be a Checkbox or Drop Down if Yes Then need to field the details else do nothing
        'MaxOverTime',
        'MinTime',
        'Status',
        'Created_At',
        'Updated_At',
        'Deleted_At',
    ];

    protected $casts = [
        'StartTime' => 'datetime:H:i:s',
        'EndTime' => 'datetime:H:i:s',
        'OverTimeYN' => 'boolean',
        'MaxOverTime' => 'decimal:2',
        'MinTime' => 'decimal:2',
    ];

    const OVERTIME_YES = 'Y';
    const OVERTIME_NO = 'N';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETED = 276;

    public $timestamps = true;
    const CREATED_AT = 'Created_At';
    const UPDATED_AT = 'Updated_At';
    const DELETED_AT = 'Deleted_At';

    // Define the relationship with the ShiftMaster model (assuming it is in the same namespace)
    public function shift()
    {
        return $this->belongsTo(ShiftMaster::class, 'ShiftID');
    }

    // Define the relationship with the Department model (assuming it is in the same namespace)
    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentId');
    }

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}
