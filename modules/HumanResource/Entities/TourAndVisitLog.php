<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAndVisitLog extends Model
{
    use HasFactory;

    protected $table='tour_and_visits_log';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tourOrVisitId',
        'appliedBy',
        'tourOrVisitInfo',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'tourOrVisitInfo' => 'json',
    ];

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id';

    /**
     * Get the TourAndVisit that owns the TourAndVisitLog.
     */
    public function tourOrVisit()
    {
        return $this->belongsTo(TourAndVisit::class, 'tourOrVisitId');
    }

    /**
     * Get the employee who applied for the TourOrVisit.
     */
    public function appliedByEmployee()
    {
        return $this->belongsTo(Employee::class, 'appliedBy');
    }
}
