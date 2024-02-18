<?php

namespace App\Domain\Users\Services\User;

use App\Application\Contracts\TmpUserRepository;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

readonly class ValidateUserService
{
    public function __construct(
        private TmpUserRepository   $tmpUserRepository,
    ) {
    }

    public function createTmpUser(string $token): TmpUser
    {
        $tmpUser = $this->findTmpUser($token);
        $data = [
            'validated_at' => Carbon::now(),
        ];
        if ($tmpUser->validated_at === null) {
            $data['first_validation'] = true;
        } elseif ($tmpUser->first_validation) {
            $data['first_validation'] = false;
        }

        $tmpUser->update($data);
        return $tmpUser;
    }

    private function findTmpUser(string $token): TmpUser
    {
        /** @var ?TmpUser $tmpUser */
        $tmpUser = $this->tmpUserRepository->findOneBy([
            'validation_token' => $token,
        ]);
        if (null === $tmpUser) {
            throw (new ModelNotFoundException())->setModel(TmpUser::class);
        }
        return $tmpUser;
    }

    public function tvtcUserUpdate(User $user): void
    {
        if (request()->has('mobile_number')) {
            $user->mobile_number = request()->mobile_number;
        }
        if (request()->has('second_name')) {
            $user->second_name = request()->second_name;
        }
        if (request()->has('third_name')) {
            $user->third_name = request()->third_name;
        }
        if (request()->has('birth_date')) {
            $user->birth_date = request()->birth_date;
        }
        if (request()->has('gender')) {
            $user->gender = request()->gender;
        }
        if (request()->has('nationality_id')) {
            $user->nationality_id = request()->nationality_id;
        }
        if (request()->has('region_id')) {
            $user->region_id = request()->region_id;
        }
        if (request()->has('city_id')) {
            $user->city_id = request()->city_id;
        }

        $user->save();
    }
}
