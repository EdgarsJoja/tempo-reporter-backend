<?php

namespace App\Team;

use App\Team;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class TeamRepository
 * @package App\Team
 */
class TeamRepository implements TeamRepositoryInterface
{
    /**
     * @param array $data
     * @param User $owner
     */
    public function createTeam(array $data, User $owner): void
    {
        $team = new Team();

        $team->fill($data);
        $team->owner_id = $owner->id;

        $owner->teams()->save($team);
    }

    /**
     * @param $teamId
     * @return Team
     * @throws ModelNotFoundException
     */
    public function getById($teamId): Team
    {
        return Team::findOrFail($teamId);
    }

    /**
     * @param Team $team
     * @param array $data
     */
    public function updateData(Team $team, array $data): void
    {
        $team->fill($data);
        $team->save();
    }
}
