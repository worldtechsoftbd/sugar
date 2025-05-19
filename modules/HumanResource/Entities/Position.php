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

class Position extends Model
{
    use HasFactory, SoftDeletes,BasicConfig;

    protected $fillable = [
        'position_name',
        'position_details',
        'is_active',
        'OverTimeYN',
        'position_short',
        'seniority_order',
    ];

    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

    public function candidates()
    {
        return $this->hasMany(CandidateSelection::class, 'position_id', 'id');
    }
}
