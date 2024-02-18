<?php

namespace App\Application\Contracts;

use App\Domain\Users\Models\User;
use App\Infrastructure\Contracts\BaseRepository;

interface UserRepository extends BaseRepository
{
    public function setNewEmailTokenConfirmation(string $userId): void;

    public function findUserWithEmailAndType(string $email, int $userTypeId): ?User;

    public function findExistingUser(string $email): ?User;

    public function findExistingUserWithAttribute(string $email, string $attribute, string $value): ?User;
}
