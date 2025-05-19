<?php

namespace Modules\Attendance\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\HumanResource\Entities\Attendance;
use Exception;

class DeviceAttendance extends Model
{
    use HasFactory;

    protected $table = 'device_attendances';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'status', // 101: initial, 201: processed
        'checkTime',
        'checkType',
        'verifyCode',
        'sensorId',
        'memoInfo',
        'workCode',
        'sn',
        'userExtFmt',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'checkTime' => 'datetime',
        'status' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship with the User model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Handle actions when creating a new record
        static::creating(function ($deviceAttendance) {
            $deviceAttendance->created_at = now();
            $deviceAttendance->status = 101; // Default status is 'initial'
        });

        // Handle actions after a record is created
        static::created(function ($deviceAttendance) {
            try {
                $user = User::findOrFail($deviceAttendance->userId);

                // Ensure the user has an associated employee
                if ($user->employee) {
                    Attendance::create([
                        'employee_id' => $user->employee->id,
                        'attendance_date' => $deviceAttendance->checkTime->format('Y-m-d'),
                        'checkType' => $deviceAttendance->checkType,
                        'verifyCode' => $deviceAttendance->verifyCode,
                        'sensorId' => $deviceAttendance->sensorId,
                        'sn' => $deviceAttendance->sn,
                        'attendance_remarks' => 'Regular Attendance', // Example value
                        'time' => $deviceAttendance->checkTime,
                    ]);

                    // Update status in the device_attendances table to 'processed'
                    $deviceAttendance->update(['status' => 201]);
                } else {
                    \Log::warning('User has no associated employee', [
                        'user_id' => $deviceAttendance->userId,
                    ]);
                }
            } catch (Exception $e) {
                // Log errors without breaking the flow
                \Log::error('Error transferring device attendance data', [
                    'error' => $e->getMessage(),
                    'device_attendance_id' => $deviceAttendance->id,
                ]);
            }
        });
    }
}
