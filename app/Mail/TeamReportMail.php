<?php

namespace App\Mail;

use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class TeamReportMail
 * @package App\Mail
 */
class TeamReportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Team
     */
    public $team;

    /**
     * TeamReportMail constructor.
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return TeamReportMail
     */
    public function build(): TeamReportMail
    {
        return $this->subject("Daily {$this->team->name} report")
            ->markdown('emails.team.report');
    }
}
