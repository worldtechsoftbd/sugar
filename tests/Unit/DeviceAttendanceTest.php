<?php
use App\Models\User;

use Modules\Attendance\Entities\DeviceAttendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceAttendanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_default_values_and_creates_an_attendance_when_a_device_attendance_is_created()
    {
        // Given
        $user = User::factory()->create();
        $deviceAttendanceData = [
            'userId' => $user->id,
            'checkTime' => '2022-02-08 09:25:14',
            'checkType' => 'I',
            'verifyCode' => '0',
            'sensorId' => '103',
            'memoInfo' => '',
            'workCode' => '0',
            'sn' => 'OBD6110586103100364',
            'userExtFmt' => '1',
        ];

        // When
        $deviceAttendance = DeviceAttendance::create($deviceAttendanceData);

        // Then
        $this->assertDatabaseHas('device_attendances', [
            'id' => $deviceAttendance->id,
            'userId' => $deviceAttendance->userId,
            'checkTime' => $deviceAttendance->checkTime,
            'checkType' => $deviceAttendance->checkType,
            'verifyCode' => $deviceAttendance->verifyCode,
            'sensorId' => $deviceAttendance->sensorId,
            'memoInfo' => $deviceAttendance->memoInfo,
            'workCode' => $deviceAttendance->workCode,
            'sn' => $deviceAttendance->sn,
            'userExtFmt' => $deviceAttendance->userExtFmt,
            'status' => 101,
        ]);

        // It should also create an attendance
        $this->assertDatabaseHas('attendances', [
            'employee_id' => $user->employee->id,
            'machine_id' => $deviceAttendance->sn,
            'machine_state' => $deviceAttendance->status,
            'time' => $deviceAttendance->checkTime,
        ]);

        // And then it should update the status to 201
        $this->assertDatabaseHas('device_attendances', [
            'id' => $deviceAttendance->id,
            'status' => 201,
        ]);

    }
}