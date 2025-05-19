<?php

namespace Modules\Organization\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Organization\Database\Factories\OrganizationOfficesFactory;

class OrganizationOffices extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organization_offices'; // Define the correct table name.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'org_id',
        'office_name',
        'description',
        'address',
        'longitude',
        'latitude',
        'status',
        'phone_number',
        'email'
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
     * The attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Define the relationship with the Organization model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }
    /**
     * The factory to use for creating instances.
     *
     * @return \Modules\Organization\Database\Factories\OrganizationOfficesFactory
     */
    protected static function newFactory(): OrganizationOfficesFactory
    {
        return OrganizationOfficesFactory::new();
    }

    /**
     * Set the status attribute to ensure valid values.
     *
     * @param mixed $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = in_array($value, [1, 2, 276]) ? $value : 1;
    }
    public function officeDetails()
    {
        return $this->hasMany(OrganizationOfficeDetails::class, 'org_offices_id');
    }



}
