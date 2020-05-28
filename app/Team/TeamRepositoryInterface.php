<?php

namespace App\Team;

use App\Team;
use App\User;
use Exception;
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
     * @return Team
     */
    public function createTeam(array $data, User $owner): Team;

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

    /**
     * Get list of teams associated to user (as owner and participant)
     *
     * @param User $user
     * @return Team[]
     */
    public function getList(User $user): array;

    /**
     * Delete team by ID
     *
     * @param $teamId
     * @throws Exception
     */
    public function delete($teamId): void;

    /**
     * Add users to team
     *
     * @param Team $team
     * @param array $ids
     */
    public function addUsers(Team $team, array $ids): void;
}
