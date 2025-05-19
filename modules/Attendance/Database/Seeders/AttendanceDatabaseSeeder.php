<?php

namespace Modules\Attendance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Attendance\Entities\Shift;

class AttendanceDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed shifts
        Shift::create([
            'name' => 'Morning Shift',
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        Shift::create([
            'name' => 'Night Shift',
            'start_time' => '18:00',
            'end_time' => '02:00',
        ]);
    }
}
