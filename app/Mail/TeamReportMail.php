<?php

namespace App\Mail;

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
     * @return TeamReportMail
     */
    public function build(): TeamReportMail
    {
        return $this->subject('Daily <TEAM_NAME> report')->markdown('emails.team.report');
    }
}
