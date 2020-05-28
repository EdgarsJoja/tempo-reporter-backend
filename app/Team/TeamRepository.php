<?php

namespace App\Team;

use App\Team;
use App\User;
use Exception;
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
     * @return Team
     */
    public function createTeam(array $data, User $owner): Team
    {
        $team = new Team();

        $team->fill($data);
        $team->owner_id = $owner->id;

        /** @var Team $savedTeam */
        $savedTeam = $owner->ownedTeams()->save($team);

        return $savedTeam;
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

    /**
     * Delete team by ID
     *
     * @param $teamId
     * @throws Exception
     */
    public function delete($teamId): void
    {
        /** @var Team $team */
        $team = Team::find($teamId);
        $team->delete();
    }

    /**
     * Add users to team
     *
     * @param Team $team
     * @param array $ids
     */
    public function addUsers(Team $team, array $ids): void
    {
        $team->users()->sync($ids);
    }
}
