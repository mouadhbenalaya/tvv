<?php

namespace Database\Seeders;

use App\Common\Models\Country;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $jim = User::firstOrCreate([
            'email' => 'jim@example.com',
        ], [
            'first_name' => 'Jim',
            'last_name' => 'Jim',
            'second_name' => 'Jim',
            'third_name' => 'Jim',
            'email' => 'jim@example.com',
            'email_verified_at' => now(),
            'password' => 'secretPassword',
            'remember_token' => Str::random(10),
            'id_number' => 321,
            'mobile_number' => '41111111',
            'lives_in_saudi_arabi' => false,
            'country_id' => Country::where('code_alpha_2', 'HR')->first()?->id,
        ]);
        $pam = User::firstOrCreate([
            'email' => 'pam@example.com',
        ], [
            'first_name' => 'Pam',
            'last_name' => 'Pam',
            'second_name' => 'Pam',
            'third_name' => 'Pam',
            'email' => 'pam@example.com',
            'email_verified_at' => now(),
            'password' => 'secretPassword',
            'remember_token' => Str::random(10),
            'id_number' => 123,
            'mobile_number' => '2222222',
            'lives_in_saudi_arabi' => true,
            'country_id' => Country::where('code_alpha_2', 'SA')->first()?->id,
        ]);

        foreach ([$jim, $pam] as $user) {
            /** @var Profile $trainee */

            $trainee = Profile::firstOrCreate([
                'user_id' => $user->id,
                'employee_number' => 12345,
                'ad_user_name' => 'username_1',
                'department_id' => 1,
                'facility_id' => 1,
                'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINEE)->first()?->id,
                ]);
            $trainee->assignRole('trainee');

            $trainer = Profile::firstOrCreate([
                'user_id' => $user->id,
                'employee_number' => 23456,
                'ad_user_name' => 'username_2',
                'department_id' => 1,
                'facility_id' => 1,
                'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINER)->first()?->id,
            ]);
            $trainer->assignRole('trainer');

            $investor = Profile::firstOrCreate([
                'user_id' => $user->id,
                'employee_number' => 34567,
                'ad_user_name' => 'username_3',
                'department_id' => 1,
                'facility_id' => 1,
                'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::ESTABLISHMENT_OPERATOR)->first()?->id,
            ]);
            $investor->assignRole('investor');

            $tvtcOperator = Profile::firstOrCreate([
                'user_id' => $user->id,
                'employee_number' => 34567,
                'ad_user_name' => 'username_4',
                'department_id' => 1,
                'facility_id' => 1,
                'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TVTC_OPERATOR)->first()?->id,
            ]);
            $tvtcOperator->assignRole('superAdmin', 'tvtc_operator', 'tvtcEmployee');
        }
    }
}
