<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\HumanResource\Entities\Employee;
use Modules\HumanResource\Entities\PointCategory;

class PointManagement extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =  [
        'id',
        'uuid',
        'employee_id',
        'point_category',
        'description',
        'point',
    ];
    
    protected static function boot()
    {
        parent::boot();
        if(Auth::check()){
            self::creating(function($model) {
                $model->uuid = (string) Str::uuid();
                $model->created_by = Auth::id();
            });

            self::updating(function($model) {
                $model->updated_by = Auth::id();
            });

            self::deleted(function($model){
                $model->updated_by = Auth::id();
                $model->save();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });

    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function pointCategory()
    {
        return $this->belongsTo(PointCategory::class,'point_category','id');
    }
}
