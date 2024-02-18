<?php

namespace Database\Seeders;

use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate([
            'name' => 'superAdmin',
        ]);
        $superAdmin->generateSlug();
        $superAdmin->update();
        $superAdmin->givePermissionTo(Permission::all());

        $tvtcOperator = Role::firstOrCreate([
            'name' => 'tvtcEmployee',
        ]);
        $tvtcOperator->generateSlug();
        $tvtcOperator->update();
        $tvtcOperator->givePermissionTo(Permission::all());

        $trainee = Role::firstOrCreate([
            'name' => 'trainee',
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINEE)->first()?->id
        ]);
        $trainee->generateSlug();
        $trainee->update();
        $trainee->givePermissionTo('view_user');
        $trainee->givePermissionTo('update_user');

        $trainer = Role::firstOrCreate([
            'name' => 'trainer',
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TRAINER)->first()?->id
        ]);
        $trainer->generateSlug();
        $trainer->update();
        $trainer->givePermissionTo('view_user');
        $trainer->givePermissionTo('update_user');

        $investor = Role::firstOrCreate([
            'name' => 'investor',
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::INVESTOR)->first()?->id
        ]);
        $investor->generateSlug();
        $investor->update();
        $investor->givePermissionTo('view_user');
        $investor->givePermissionTo('update_user');

        $tvtcOperator = Role::firstOrCreate([
            'name' => 'tvtc_operator',
            'user_type_id' => UserType::where('name', \App\Domain\Users\Enums\UserType::TVTC_OPERATOR)->first()?->id
        ]);
        $tvtcOperator->generateSlug();
        $tvtcOperator->update();
        $tvtcOperator->givePermissionTo('update_user');
        $tvtcOperator->givePermissionTo('update_user');
    }
}
