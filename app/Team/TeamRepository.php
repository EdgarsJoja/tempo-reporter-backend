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

        $owner->ownedTeams()->save($team);
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

    /**
     * Get list of teams associated to user (as owner and participant)
     *
     * @param User $user
     * @return Team[]
     */
    public function getList(User $user): array
    {
        $ownedTeams = $user->ownedTeams()->get()->map(static function ($team) {
            $team['owned'] = true;
            return $team;
        })->toArray();

        // @todo: Add participant teams

        return $ownedTeams;
    }
}
