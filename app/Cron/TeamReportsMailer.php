<?php

namespace App\Cron;

use App\Mail\TeamReportMail;
use App\Team;
use App\User;
use App\User\UserDataPresentationInterface;
use App\UserReport;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

/**
 * Class TeamReportsMailer
 * @package App\Cron
 */
class TeamReportsMailer
{
    /**
     * @var UserDataPresentationInterface
     */
    protected $userDataPresentation;

    /**
     * Invoke
     * @param UserDataPresentationInterface $userDataPresentation
     */
    public function __invoke(UserDataPresentationInterface $userDataPresentation)
    {
        $this->userDataPresentation = $userDataPresentation;

        $teams = $this->getTeamsWithCurrentReportTime();

        /** @var Team $team */
        foreach ($teams as $team) {
            $mail = new TeamReportMail($team);

            Mail::to($team->owner->email)->send($mail->with('reports', $this->prepareUsersReportData($team)));
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

    /**
     * @param Team $team
     * @return array
     */
    protected function prepareUsersReportData(Team $team): array
    {
        $result = [];

        /** @var User $user */
        foreach ($team->users()->get() as $user) {
            try {
                /** @var UserReport $report */
                $report = $user->reports()
                    ->whereDate('report_date', '=', Carbon::today())
                    ->firstOrFail();

                $result[] = [
                    'user_title' => $this->userDataPresentation->wrap($user)->getTitle(),
                    'report' => $report->report
                ];
            } catch (ModelNotFoundException $e) {
                // @todo: Handle exceptions somehow, at least log
                continue;
            } catch (Exception $e) {
                continue;
            }
        }

        return $result;
    }
}
