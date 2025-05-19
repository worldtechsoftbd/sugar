<?php

namespace Modules\Payroll\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaymentOrDeductionTypes extends Model
{
    use HasFactory,BasicConfig,SoftDeletes;

    protected $table = 'payment_or_deduction_types';

    protected $fillable = [
        'uuid',
        'pay_or_ded',
        'description',
        'remarks',
        'status',
        'created_by',
        'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }
}
