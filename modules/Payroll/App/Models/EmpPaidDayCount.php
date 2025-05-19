<?php

namespace Modules\Payroll\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Employee;


class EmpPaidDayCount extends Model
{
    use HasFactory,BasicConfig,SoftDeletes;

    protected $table = 'emp_paid_day_count';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'payroll_id',
        'payment_date',
        'year_month',
        'default_date',
        'day_count',
        'day_paid',
        'is_paid',
        'status',
        'ready_to_pay',
        'end_date',
        'remarks',
        'emp_status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'default_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
