<?php

namespace App\User;

use App\TempoData;
use App\User;
use Illuminate\Support\Facades\Log;

/**
 * Class UserTempoDataRepository
 * @package App\User
 */
class UserTempoDataRepository implements UserTempoDataRepositoryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserTempoDataRepository constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function getTempoData(string $userToken): TempoData
    {
        return $this->userRepository->getByToken($userToken)->tempoData;
    }

    /**
     * @inheritDoc
     */
    public function updateTempoData(string $userToken, array $data): bool
    {
        Log::debug($data);
        $user = $this->userRepository->getByToken($userToken);
        // @todo: Create interfaces for models and inject factories instead
        $tempoData = $user->tempoData ?? $this->initTempoDataModel($user);

        $tempoData->fill($data);

        return $tempoData->save();
    }

    /**
     * Create new tempo data object
     * @todo: Move this into factory
     *
     * @param User $user
     * @return TempoData
     */
    protected function initTempoDataModel(User $user): TempoData
    {
        /** @var TempoData $tempoData */
        $tempoData = $user->tempoData()->newModelInstance();

        $tempoData->user_id = $user->id;

        return $tempoData;
    }
}
