<?php

namespace Database\Seeders;

use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Seeder;

class TmpUserSeeder extends Seeder
{
    public function run(): void
    {
        TmpUser::firstOrCreate([
            'email' => 'jim@example.com',
        ], [
            'email' => 'jim@example.com',
            'user_type_id' => UserType::select('id')->orderBy('id')->first()?->id,
            'validation_token' => 'somerandomtokenforjim',
            'validated_at' => '2023-12-01 00:22:44',
            'first_validation' => true,
        ]);
        TmpUser::firstOrCreate([
            'email' => 'pam@q.agency',
        ], [
            'email' => 'pam@q.agency',
            'user_type_id' => UserType::all()->random()->id,
            'validation_token' => 'somerandomtokenforpam',
            'validated_at' => '2023-01-01 22:00:44',
            'first_validation' => false,
        ]);
        TmpUser::firstOrCreate([
            'email' => 'jim@example.com',
            'validation_token' => 'somerandomtokenforjim_2',
        ], [
            'email' => 'jim@example.com',
            'user_type_id' => UserType::select('id')->orderBy('id', 'DESC')->first()?->id,
            'validation_token' => 'somerandomtokenforjim_2',
            'validated_at' => '2023-01-01 11:33:55',
        ]);
    }
}
