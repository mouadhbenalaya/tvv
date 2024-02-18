<?php

namespace App\Domain\Users\Services\User;

use App\Application\Contracts\TmpUserRepository;
use App\Application\Contracts\UserRepository;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

readonly class CheckUserService
{
    public function __construct(
        private UserRepository    $userRepository,
        private TmpUserRepository $tmpUserRepository,
    ) {
    }

    public function getExistingUser(array $requestData): ?User
    {
        return $this->userRepository->findUserWithEmailAndType(
            email: $requestData['email'],
            userTypeId: $requestData['user_type_id']
        );
    }

    public function createTmpUser(?User $userWithType, array $requestData): TmpUser
    {
        if (null !== $userWithType) {
            throw ValidationException::withMessages(['user_exist' => true]);
        }

        /** @var ?User $user */
        $user = $this->userRepository->findOneBy([
            'email' => $requestData['email'],
        ]);
        return $this->createOrUpdateTmpUser($user, $requestData);
    }

    private function createOrUpdateTmpUser(?User $user, array $requestData): TmpUser
    {
        /** @var ?TmpUser $tmpUser */
        $tmpUser = $this->tmpUserRepository->findOneBy($requestData);
        if (null === $tmpUser) {
            return TmpUser::create([
                'email' => $requestData['email'],
                'validation_token' => Str::random(64),
                'user_type_id' => $requestData['user_type_id'],
                'user_id' => $user?->id,
            ]);
        }
        $this->tmpUserRepository->update($tmpUser, [
            'validation_token' => Str::random(64),
            'user_id' => $user?->id,
        ]);
        return $tmpUser;
    }
}
