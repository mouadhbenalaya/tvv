<?php

namespace Database\Seeders;

use App\Domain\Users\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
        $establishmentOperator = UserType::firstOrCreate([
            'name' => \App\Domain\Users\Enums\UserType::ESTABLISHMENT_OPERATOR->value,
            'can_register' => false,
        ]);
        $establishmentOperator->generateSlug();
        $establishmentOperator->update();
        $trainer = UserType::firstOrCreate([
            'name' => \App\Domain\Users\Enums\UserType::TRAINER->value,
            'can_register' => true,
        ]);
        $trainer->generateSlug();
        $trainer->update();
        $trainee = UserType::firstOrCreate([
            'name' => \App\Domain\Users\Enums\UserType::TRAINEE->value,
            'can_register' => true,
        ]);
        $trainee->generateSlug();
        $trainee->update();
        $tvtcOperator = UserType::firstOrCreate([
            'name' => \App\Domain\Users\Enums\UserType::TVTC_OPERATOR->value,
            'can_register' => false,
        ]);
        $tvtcOperator->generateSlug();
        $tvtcOperator->update();
        $investor = UserType::firstOrCreate([
            'name' => \App\Domain\Users\Enums\UserType::INVESTOR->value,
            'can_register' => true,
        ]);
        $investor->generateSlug();
        $investor->update();
    }
}
