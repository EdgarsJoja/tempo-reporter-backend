<?php

namespace App\Team;

use App\Team;

/**
 * Interface TeamReportsGeneratorInterface
 * @package App\Team
 */
interface TeamReportsGeneratorInterface
{
    /**
     * Generate reports for all team users
     *
     * @param Team $team
     */
    public function generate(Team $team): void;
}
