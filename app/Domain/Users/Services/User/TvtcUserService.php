<?php

namespace App\Domain\Users\Services\User;

use App\Application\Contracts\ProfileRepository;
use App\Application\Contracts\UserRepository;
use App\Domain\Users\Models\User;
use App\Domain\Users\Notifications\Registration\TvtcOperatorCreatedSuccessfully;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

readonly class TvtcUserService
{
    public function __construct(
        private UserRepository    $userRepository,
        private ProfileRepository $profileRepository,
    ) {
    }

    public function createUser(array $requestData, array $profileData): User
    {
        $password = \Str::password(12);
        $user = $this->storeUser($requestData, $password);
        $this->storeProfile($user, $profileData);
        $token = Password::createToken($user);
        Notification::send($user, new TvtcOperatorCreatedSuccessfully($token));

        return $user;
    }

    private function storeUser(array $userData, string $password): User
    {
        $userData['password'] = $password;
        /** @var User $user */
        $user = $this->userRepository->store($userData);
        return $user;
    }

    private function storeProfile(User $user, array $profileData): void
    {
        $profileData['user_id'] = $user->id;
        $this->profileRepository->store($profileData);
    }
}
