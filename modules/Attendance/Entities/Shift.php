<?php

namespace Modules\Attendance\Entities;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;
    use BasicConfig;

    protected $table = 'shifts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'uuid',
        'start_time',
        'end_time',
        'grace_period',
        'is_next_day',
        'status',
        'description',
        'isApplicableGracePeriod',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'grace_period' => 'integer',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETED = 276;

    public $timestamps = true;


    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

    /**
     * Override the delete method to update the status instead of soft deleting.
     */
    /**
     * Override the delete method.
     */
    public function delete()
    {
        $this->update([
            'status' => self::STATUS_DELETED,
            'deleted_at' => now(),
        ]);

        // Call the parent's delete method to handle soft delete properly.
        parent::delete();
    }
}
