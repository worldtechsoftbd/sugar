<?php

namespace Modules\Organization\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HumanResource\Entities\Department;
use Modules\HumanResource\Entities\Employee;

class OrgOfficeHead extends Model
{
    use HasFactory, SoftDeletes, BasicConfig;

    /**
     * The table associated with the model.
     */
    protected $table = 'org_office_head';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'uuid',
        'started_date',
        'org_office_id',
        'emp_id',
        'status',
    ];

    protected $casts = [
        'started_date' => 'datetime',
        'status' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }


    public function departments()
    {
        return $this->belongsTo(Department::class, 'org_office_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'id');
    }
}
