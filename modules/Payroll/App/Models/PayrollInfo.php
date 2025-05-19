<?php

namespace Modules\Payroll\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Employee;
use Modules\Payroll\Database\factories\PayrollInfoFactory;

class PayrollInfo extends Model
{
    use HasFactory, BasicConfig, SoftDeletes;

    protected $table = 'payroll_infos';

    protected $fillable = [
        'uuid',
        'emp_id',
        'payrollId',
        'remarks',
        'status',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}
