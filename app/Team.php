<?php

namespace App;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected $hidden = [
        'owner_id'
    ];

    /**
     * Remove seconds part from mysql time column type
     *
     * @param $value
     * @return string
     * @throws Exception
     */
    public function getReportTimeAttribute($value): string
    {
        return (new DateTime($value))->format('H:i');
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * Get team users
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'teams_users',
            'team_id',
            'user_id'
        );
    }
}
