<?php

namespace App\Domain\Users\Services\User;

use App\Application\Contracts\ProfileRepository;
use App\Application\Contracts\TmpUserRepository;
use App\Application\Contracts\UserRepository;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use App\Domain\Users\Notifications\Registration\UserCreatedSuccessfully;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;

readonly class RegisterUserService
{
    public function __construct(
        private UserRepository    $userRepository,
        private TmpUserRepository $tmpUserRepository,
        private ProfileRepository $profileRepository,
    ) {
    }

    public function createUser(array $requestData, int $userTypeId = null): User
    {
        if ($userTypeId) {
            $requestData['email_verified_at'] = Carbon::now();
            /** @var User $user */
            $user = $this->userRepository->store($requestData);
            $this->createNewProfile($user, $userTypeId);

            Notification::send($user, new UserCreatedSuccessfully());
        } else {
            $tmpUser = $this->findTmpUser($requestData['token']);
            $user = $this->userRepository->findExistingUser($tmpUser->email);
            if (null === $user) {
                $requestData['email'] = $tmpUser->email;
                $requestData['email_verified_at'] = $tmpUser->validated_at;
                /** @var User $user */
                $user = $this->userRepository->store($requestData);

                Notification::send($user, new UserRegisteredSuccessfully());
            }
            $this->activateOrCreateProfile($user, $tmpUser);
            $tmpUser->delete();
        }

        return $user;
    }

    private function findTmpUser(string $token): TmpUser
    {
        $tmpUser = $this->tmpUserRepository->findValidatedTmpUser($token);

        if (null === $tmpUser) {
            throw (new ModelNotFoundException())->setModel(TmpUser::class);
        }
        return $tmpUser;
    }

    private function activateOrCreateProfile(User $user, TmpUser $tmpUser): void
    {
        /** @var UserType $userType */
        $userType = $tmpUser->userType()->first();
        /** @var ?Profile $profile */
        $profile = $this->profileRepository->findDeletedUserProfile($user, $userType);
        if (null !== $profile) {
            $profile->restore();
        } else {
            $this->createNewProfile($user, $tmpUser->user_type_id);
        }
    }

    private function createNewProfile(User $user, int $userTypeId): void
    {
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->user_type_id = $userTypeId;
        $user->profiles()->save($profile);
        $this->assignInvestorRoleToEstablishmentOperator($profile);
    }

    private function assignInvestorRoleToEstablishmentOperator(Profile $profile): void
    {
        if ($profile->userType()->first()?->name === \App\Domain\Users\Enums\UserType::ESTABLISHMENT_OPERATOR->value) {
            $profile->assignRole('investor');
        }
    }
}
