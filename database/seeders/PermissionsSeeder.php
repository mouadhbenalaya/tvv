<?php

namespace Database\Seeders;

use App\Domain\Users\Models\Permission;
use Illuminate\Database\Seeder;
use App\Domain\Users\Enums\Permission as PermissionEnum;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $createRole = Permission::firstOrCreate([
            'name' => PermissionEnum::CREATE_ROLE->value,
        ]);
        $createRole->generateSlug();
        $createRole->update();

        $deleteRole = Permission::firstOrCreate([
            'name' => PermissionEnum::DELETE_ROLE->value,
        ]);
        $deleteRole->generateSlug();
        $deleteRole->update();

        $updateRole = Permission::firstOrCreate([
            'name' => PermissionEnum::UPDATE_ROLE->value,
        ]);
        $updateRole->generateSlug();
        $updateRole->update();

        $assignRole = Permission::firstOrCreate([
            'name' => PermissionEnum::ASSIGN_ROLE->value,
        ]);
        $assignRole->generateSlug();
        $assignRole->update();

        $revokeRole = Permission::firstOrCreate([
            'name' => PermissionEnum::REVOKE_ROLE->value,
        ]);
        $revokeRole->generateSlug();
        $revokeRole->update();

        $viewAllPermissions = Permission::firstOrCreate([
            'name' => PermissionEnum::VIEW_ALL_PERMISSIONS->value,
        ]);
        $viewAllPermissions->generateSlug();
        $viewAllPermissions->update();

        $viewAllUsers = Permission::firstOrCreate([
            'name' => PermissionEnum::VIEW_ALL_USERS->value,
        ]);
        $viewAllUsers->generateSlug();
        $viewAllUsers->update();

        $viewUser = Permission::firstOrCreate([
            'name' => PermissionEnum::VIEW_USER->value,
        ]);
        $viewUser->generateSlug();
        $viewUser->update();

        $creteUser = Permission::firstOrCreate([
            'name' => PermissionEnum::CREATE_USER->value,
        ]);
        $creteUser->generateSlug();
        $creteUser->update();

        $updateUser = Permission::firstOrCreate([
            'name' => PermissionEnum::UPDATE_USER->value,
        ]);
        $updateUser->generateSlug();
        $updateUser->update();

        $deleteUser = Permission::firstOrCreate([
            'name' => PermissionEnum::DELETE_USER->value,
        ]);
        $deleteUser->generateSlug();
        $deleteUser->update();

        $viewAllDepartments = Permission::firstOrCreate([
            'name' => PermissionEnum::VIEW_ALL_DEPARTMENTS->value,
        ]);
        $viewAllDepartments->generateSlug();
        $viewAllDepartments->update();

        $viewDepartment = Permission::firstOrCreate([
            'name' => PermissionEnum::VIEW_DEPARTMENT->value,
        ]);
        $viewDepartment->generateSlug();
        $viewDepartment->update();

        $updateDepartment = Permission::firstOrCreate([
            'name' => PermissionEnum::UPDATE_DEPARTMENT->value,
        ]);
        $updateDepartment->generateSlug();
        $updateDepartment->update();

        $deleteDepartment = Permission::firstOrCreate([
            'name' => PermissionEnum::DELETE_DEPARTMENT->value,
        ]);
        $deleteDepartment->generateSlug();
        $deleteDepartment->update();

        $createDepartment = Permission::firstOrCreate([
            'name' => PermissionEnum::CREATE_DEPARTMENT->value,
        ]);
        $createDepartment->generateSlug();
        $createDepartment->update();

        $assignProfile = Permission::firstOrCreate([
            'name' => PermissionEnum::ASSIGN_PROFILE->value,
        ]);
        $assignProfile->generateSlug();
        $assignProfile->update();

        $removeProfile = Permission::firstOrCreate([
            'name' => PermissionEnum::REMOVE_PROFILE->value,
        ]);
        $removeProfile->generateSlug();
        $removeProfile->update();
    }
}
