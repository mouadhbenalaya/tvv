<?php

namespace App\Domain\Users\Services;

use App\Application\Contracts\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

readonly class DisableAccountService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function handle(string $token): mixed
    {
        $user = $this->userRepository->findOneBy([
            'email_token_disable_account' => $token,
        ]);

        try {
            return DB::transaction(function () use ($user) {
                $user?->update(['is_active' => 0]);

                //Notification::send($user, new AccountDisabledNotification());

                $this->logoutUserIfNecessary();

                return true;
            });
        } catch (\Exception $exception) {
            return [
                'error' => true,
                'message' => __('We could not disable your account, please try again or enter in contact with the ' .
                    'support'),
            ];
        }
    }

    private function logoutUserIfNecessary(): void
    {
        if (auth()->check()) {
            Cache::forget((string)auth()->id());
            Cache::tags('users:' . auth()->id())->flush();
            auth()->logout();
        }
    }
}
