<?php

namespace Modules\Organization\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\Entities\Department;
use Modules\Organization\Database\Factories\OrganizationFactory;

class Organization extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organization'; // Ensure the table name is specified correctly.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'org_name',
        'description',
        'address',
        'phone_number',
        'email',
        'longitude',
        'latitude',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'longitude' => 'decimal:6',
        'latitude'  => 'decimal:6',
        'status'    => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The factory to use for creating instances.
     *
     * @return \Modules\Organization\Database\Factories\OrganizationFactory
     */
    protected static function newFactory(): OrganizationFactory
    {
        return OrganizationFactory::new();
    }

    /**
     * The attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Set the status attribute to ensure valid values.
     *
     * @param mixed $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        // Default to active if status is null or invalid
        $this->attributes['status'] = in_array($value, [1, 2, 276]) ? $value : 1;
    }
    public function departments()
    {
        return $this->hasMany(Department::class, 'organization_id', 'id'); // Assuming foreign key is 'organization_id'
    }

}
