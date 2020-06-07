<?php

namespace App\Cron;

use App\Team;
use App\Team\TeamReportsGeneratorInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TeamReportsGenerator
 * @package App\Cron
 */
class TeamReportsGenerator
{
    /**
     * How many minutes ahead to check teams and generate reports
     */
    protected const MINUTES_GENERATE_AHEAD = 5;

    /**
     * @var TeamReportsGeneratorInterface
     */
    protected $teamReportsGenerator;

    /**
     * Execute functionality
     * @param TeamReportsGeneratorInterface $teamReportsGenerator
     */
    public function __invoke(TeamReportsGeneratorInterface $teamReportsGenerator)
    {
        $this->teamReportsGenerator = $teamReportsGenerator;

        $teams = $this->getTeamsWithUpcomingReports();

        /** @var Team $team */
        foreach ($teams as $team) {
            $this->teamReportsGenerator->generate($team);
        }
    }

    /**
     * Get teams that have scheduled reports soon
     * @return Collection
     */
    protected function getTeamsWithUpcomingReports(): Collection
    {
        $datetime = new Carbon();
        // @todo: Make this change global
        $datetime->timezone(env('APP_TIMEZONE'));

        $currentTime = $datetime->toTimeString();
        $aheadTime = $datetime->addMinutes(self::MINUTES_GENERATE_AHEAD)->toTimeString();

        return Team::whereBetween('report_time', [$currentTime, $aheadTime])->get();
    }
}
