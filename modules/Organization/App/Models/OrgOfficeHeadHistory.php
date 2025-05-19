<?php

namespace Modules\Organization\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgOfficeHeadHistory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'org_office_head_history';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'org_office_head_id',
        'uuid',
        'started_date',
        'ended_date',
        'org_office_id',
        'emp_id',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'started_date' => 'datetime',
        'ended_date' => 'datetime',
        'status' => 'integer',
    ];

    /**
     * Define the relationship with OrgOfficeHead.
     */
    public function orgOfficeHead()
    {
        return $this->belongsTo(OrgOfficeHead::class, 'org_office_head_id');
    }
}
