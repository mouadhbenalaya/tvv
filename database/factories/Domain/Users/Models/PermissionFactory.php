<?php

namespace Database\Factories\Domain\Users\Models;

use App\Domain\Users\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Users\Enums\Permission as PermissionEnum;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(PermissionEnum::cases()),
        ];
    }

    public function canCreateRole(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::CREATE_ROLE,
        ]);
    }

    public function canDeleteRole(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::DELETE_ROLE,
        ]);
    }

    public function canAssignRole(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::ASSIGN_ROLE,
        ]);
    }

    public function canRevokeRole(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::REVOKE_ROLE,
        ]);
    }

    public function canViewAllUsers(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::VIEW_ALL_USERS,
        ]);
    }

    public function canViewUser(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::VIEW_USER,
        ]);
    }

    public function canCreateUser(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::CREATE_USER,
        ]);
    }

    public function canEditUser(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::UPDATE_USER,
        ]);
    }

    public function canDeleteUser(): self
    {
        return $this->state(fn () => [
            'name' => PermissionEnum::DELETE_USER,
        ]);
    }
}
