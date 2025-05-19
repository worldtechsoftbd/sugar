<?php

namespace Modules\HumanResource\Entities;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLeaveBalanceHistory extends Model
{
    use HasFactory, softDeletes, BasicConfig;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'leave_balance_id',
        'uuid',
        'emp_id',
        'leave_type_id',
        'leave_balance',
        'leave_spent',
        'cr_leave_balance',
        'remarks',
        'status',
    ];
    protected $table="employee_leave_balance_history";

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}
