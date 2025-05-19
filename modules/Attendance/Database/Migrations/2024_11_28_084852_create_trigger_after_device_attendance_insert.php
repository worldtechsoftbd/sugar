<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER after_device_attendance_insert 
            AFTER INSERT ON device_attendances
            FOR EACH ROW
            BEGIN
              DECLARE emp_id INT;
  
              -- Fetching employee id
              SELECT employee_id INTO emp_id FROM employees 
              INNER JOIN users ON employees.user_id = users.id
              WHERE users.id = NEW.userId;
    
              -- Inserting into Attendance
              INSERT INTO attendances(employee_id, attendance_date, checkType, verifyCode,
              sensorId, sn, attendance_remarks, time) 
              VALUES(emp_id,
                DATE(NEW.checkTime),
                NEW.checkType,
                NEW.verifyCode,
                NEW.sensorId,
                NEW.sn,
                "Regular Attendance",
                NEW.checkTime
              );
    
              -- Updating status in device_attendances to "processed"
             -- UPDATE device_attendances SET status = 201 WHERE id = NEW.id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `after_device_attendance_insert`');
    }
};
