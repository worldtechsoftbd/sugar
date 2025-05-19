<?php

namespace Modules\HumanResource\Http\Functions;

use Modules\HumanResource\Entities\Employee;

class EmployeeFunction
{
    public static function getEmployeeDetailsFormatted($employeeId)
    {
        $employee = Employee::find($employeeId);
        if (!$employee) return 'N/A';
        return $employee->first_name . ' - ' . $employee->employee_id . ' - ' . ($employee->department->department_name ?? 'N/A') . ' - ' . ($employee->position->position_name ?? 'N/A');
    }
}