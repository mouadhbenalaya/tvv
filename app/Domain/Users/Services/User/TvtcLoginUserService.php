<?php

namespace App\Domain\Users\Services\User;

use App\Application\Contracts\ProfileRepository;
use App\Application\Contracts\UserRepository;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

readonly class TvtcLoginUserService
{
    public function __construct(
        private UserRepository    $userRepository,
        private ProfileRepository $profileRepository,
    ) {
    }

    public function loginUser(string $idNumber, string $password): string
    {
        /** @var ?User $user */
        $user = $this->userRepository->findOneBy([
           'id_number' => $idNumber,
        ]);

        /** @var ?Profile $profile */
        $profile = $this->profileRepository->findOneBy([
           'user_id' => $user?->id,
           'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TVTC_OPERATOR)->first()?->id,
        ]);

        $this->attemptLogin($user, $profile, $password);
        return (string)$user?->createToken(name: strtolower((string)$profile?->userType()?->first()?->name))?->plainTextToken;
    }

    private function attemptLogin(?User $user, ?Profile $profile, string $password): void
    {
        if (null !== $profile && null !== $user?->email_verified_at) {
            $credentials = [
                'email' => $user->email,
                'password' => $password,
            ];

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
