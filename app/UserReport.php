<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserReport
 * @package App
 *
 * @property $report_date
 * @property string report
 */
class UserReport extends Model
{
    protected $table = 'user_reports';

    protected $fillable = [
        'report_date', 'report'
    ];

    /**
     * @param $value
     * @return array
     */
    public function getReportAttribute($value): array
    {
        return json_decode($value, true);
    }
}
