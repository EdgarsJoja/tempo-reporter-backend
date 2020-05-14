<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Team
 * @package App
 *
 * @property $id
 * @property $owner_id
 * @property $name
 * @property $report_time
 */
class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
        'name', 'report_time'
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }
}
