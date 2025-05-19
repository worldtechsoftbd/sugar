<?php

namespace Modules\Organization\App\Models;

namespace Modules\Organization\App\Models;

use App\Traits\BasicConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShiftMaster extends Model
{
    use SoftDeletes;
    use BasicConfig;

    protected $table = 'shift_master';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ShiftName',
        'Description',
        'StartTime',
        'EndTime',
        'GracePeriod',
        'IsApplicableGracePeriod',
        'Status',
    ];

    protected $casts = [
        'StartTime' => 'datetime:H:i:s',
        'EndTime' => 'datetime:H:i:s',
        'GracePeriod' => 'integer',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETED = 276;

    public $timestamps = true;
    const CREATED_AT = 'Created_At';
    const UPDATED_AT = 'Updated_At';
    const DELETED_AT = 'Deleted_At';


    protected static function boot()
    {
        parent::boot();
        static::bootBasicConfigs();
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }
}
