<?php

namespace App\Team;

use App\Team;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface TeamRepositoryInterface
 * @package App\Team
 */
interface TeamRepositoryInterface
{
    /**
     * @param array $data
     * @param User $owner
     */
    public function createTeam(array $data, User $owner): void;

    /**
     * @param $teamId
     * @return Team
     * @throws ModelNotFoundException
     */
    public function getById($teamId): Team;

    /**
     * @param Team $team
     * @param array $data
     */
    public function updateData(Team $team, array $data): void;
}
