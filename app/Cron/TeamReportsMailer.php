<?php

namespace App\Cron;

use App\Mail\TeamReportMail;
use App\Team;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Mail;

/**
 * Class TeamReportsMailer
 * @package App\Cron
 */
class TeamReportsMailer
{
    /**
     * @var CarbonInterface
     */
    protected $datetime;

    /**
     * @param CarbonInterface $datetime
     */
    public function __invoke(CarbonInterface $datetime)
    {
        $this->datetime = $datetime;

        $teams = $this->getTeamsWithCurrentReportTime();

        /** @var Team $team */
        foreach ($teams as $team) {
            Mail::to($team->owner->email)->send(new TeamReportMail($team));
        }
    }

    /**
     * @return mixed
     */
    protected function getTeamsWithCurrentReportTime()
    {
        $datetime = new Carbon();
        // @todo: Make this change global
        $datetime->timezone(env('APP_TIMEZONE'));

        $lowTime = $datetime->subSeconds(30)->toTimeString();
        $highTime = $datetime->addMinute()->toTimeString();

        return Team::whereBetween('report_time', [$lowTime, $highTime])->get();
    }
}
