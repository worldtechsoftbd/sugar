<?php

namespace Modules\HumanResource\Entities;

use App\Traits\BasicConfig;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\Entities\CandidateSelection;

class FunctionalDesignation extends Model
{
    use HasFactory, SoftDeletes,BasicConfig;
    protected $table = 'functional_designations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'functional_designation',
        'designation_details',
        'status',
        'designation_short',
        'seniority_order',
    ];

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

}
