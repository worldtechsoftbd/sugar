<?php

namespace Modules\Organization\App\Models;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\Entities\Employee;
use Modules\Organization\App\Models\OrganizationOffices;


class OrganizationDepartment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='departments';
    protected $fillable = [
        'department_name',
        'parent_id',
        'is_active',
        'org_offices_id', // Foreign key to OrganizationOffices table
        'description',
        'address',
        'longitude',
        'latitude',
        'status',
        'phone_number',
        'email',
    ];

    protected $casts = [
        'longitude' => 'decimal:6',
        'latitude'  => 'decimal:6',
        'status'    => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            self::creating(function ($model) {
                $model->uuid = (string) Str::uuid();
                $model->created_by = Auth::id();
            });

            self::updating(function ($model) {
                $model->updated_by = Auth::id();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    /**
     * Relationship with parent department
     */
    public function parentDept()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /*public function parent()
    {
        return $this->belongsTo(OrganizationDepartment::class, 'parent_id');
    }*/

    public function office()
    {
        return $this->belongsTo(OrganizationOffices::class, 'org_offices_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    // Define the relationship for child departments
    public function children()
    {
        return $this->hasMany(OrganizationDepartment::class, 'parent_id');
    }
    public function org_offices()
    {
        return $this->hasMany(OrganizationOffices::class, 'id','org_offices_id');
    }

    /**
     * Relationship with employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    /**
     * Relationship with organization offices
     */
    public function organizationOffice()
    {
        return $this->belongsTo(OrganizationOffices::class, 'org_offices_id');
    }
}
