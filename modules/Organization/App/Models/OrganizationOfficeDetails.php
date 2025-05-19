<?php

namespace Modules\Organization\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Organization\Database\Factories\OrganizationOfficeDetailsFactory;

class OrganizationOfficeDetails extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organization_office_details'; // Define the correct table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'org_offices_id',
        'office_name',
        'description',
        'address',
        'phone_number',
        'email',
        'longitude',
        'latitude',
        'status',
        'sort_order',
        'is_parent',
        'parent_id',
        'manager_name',
        'manager_phone',
        'manager_email',
        'notes'
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
        'is_parent' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'parent_id' => 'integer',
    ];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Define the relationship with the Org_Offices model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orgOffices()
    {
        return $this->belongsTo(OrganizationOffices::class, 'org_offices_id');
    }

    /**
     * Define the self-referencing relationship (parent office).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentOffice()
    {
        return $this->belongsTo(OrganizationOfficeDetails::class, 'parent_id');
    }

    /**
     * The factory to use for creating instances.
     *
     * @return \Modules\Organization\Database\Factories\OrganizationOfficeDetailsFactory
     */
    protected static function newFactory(): OrganizationOfficeDetailsFactory
    {
        return OrganizationOfficeDetailsFactory::new();
    }
}
