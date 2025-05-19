<?php

namespace Modules\Payroll\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Employee;


class EmployeeSalary extends Model
{
    use HasFactory,BasicConfig,SoftDeletes;

    protected $table = 'employee_salaries';

    protected $fillable = [
        'uuid',
        'emp_id',
        'payroll_info_id',
        'pay_or_ded',
        'type_id',
        'amount',
        'remarks',
        'status',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function type()
    {
        return $this->belongsTo(PaymentOrDeductionTypes::class, 'type_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}
