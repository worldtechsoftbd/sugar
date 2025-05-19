<?php

namespace Modules\HumanResource\Entities;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourAndVisit extends Model
{
    use HasFactory,BasicConfig,SoftDeletes;

    protected $table='tour_and_visits';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'emp_id',
        'applied_year',
        'type_id',
        'applied_date',
        'started_date',
        'end_date',
        'appliedStatus',
        'responsiblePerson',
        'remarks',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'applied_date' => 'date:Y-m-d',
        'started_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id';


    /**
     * Get the employee that owns the TourAndVisit.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    /**
     * Get the responsible employee.
     */
    public function responsibleEmployee()
    {
        return $this->belongsTo(Employee::class, 'responsiblePerson');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();

        static::updating(function ($model) {
            if ($model->isDirty()) {
                TourAndVisitLog::create([
                    'tourOrVisitId' => $model->id,
                    'appliedBy' => $model->emp_id,
                    'tourOrVisitInfo' => [
                        'applied_year' => $model->getOriginal('applied_year'),
                        'type_id' => $model->getOriginal('type_id'),
                        'applied_date' => date('Y-m-d', strtotime($model->getOriginal('applied_date'))),
                        'started_date' => date('Y-m-d', strtotime($model->getOriginal('started_date'))),
                        'end_date' => date('Y-m-d', strtotime($model->getOriginal('end_date'))),
                        'appliedStatus' => $model->getOriginal('appliedStatus'),
                        'responsiblePerson' => $model->getOriginal('responsiblePerson'),
                        'remarks' => $model->getOriginal('remarks'),
                        'status' => $model->getOriginal('status'),
                    ],
                ]);
            }
        });
    }
}
