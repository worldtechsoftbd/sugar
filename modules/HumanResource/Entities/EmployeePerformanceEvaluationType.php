<?php

namespace Modules\HumanResource\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeePerformanceEvaluationType extends Model
{
    use HasFactory;

    protected $fillable = ['type_name', 'type_no'];
    
    
}
