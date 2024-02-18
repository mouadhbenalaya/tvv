<?php

namespace App\Domain\Users\Managers;

use App\Application\Contracts\UserRepository;
use App\Application\Contracts\UserTypeRepository;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

readonly class UserManager
{
    public function __construct(
        private UserRepository $userRepository,
        private UserTypeRepository $userTypeRepository
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function validateAndCreateTokenByType(User $user, int $userTypeId): string
    {
        /** @var ?User $existingUser */
        $existingUser = $this->userRepository->findUserWithEmailAndType(
            email: $user->email,
            userTypeId: $userTypeId
        );

        if (null === $existingUser) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        $this->deleteCurrentAccessToken($user);

        /** @var UserType $userType */
        $userType = $this->userTypeRepository->findOneBy(['id' => $userTypeId]);

        return $user->createToken(name: strtolower($userType->name))->plainTextToken;
    }

    public function deleteCurrentAccessToken(User $user): void
    {
        /** @var ?PersonalAccessToken $personalAccessToken */
        $personalAccessToken = $user->currentAccessToken();
        $personalAccessToken?->delete();
    }
}
