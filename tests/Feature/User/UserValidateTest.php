<?php

declare(strict_types=1);

namespace Feature\User;

use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserValidateTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn200WhenValidatingToken(): void
    {
        $response = $this->put(
            sprintf('%s/%s', self::USERS_VALIDATE_ENDPOINT, self::REGISTRATION_TOKEN)
        );

        $response->assertSuccessful();
        $response->assertJson([
            'id' => 1,
            'email' => 'jim@example.com',
            'validation_token' => 'somerandomtokenforjim',
            'user_type_id' => 1,
            'first_validation' => false,
            'user_exist' => false,
        ]);
        $response->assertJsonStructure($this->validationStructure());
    }

    public function testShouldReturn200WhenValidatingTokenWhenUserExistAndProfilesAreDeleted(): void
    {
        $this->createUserWithDeletedProfile();
        $response = $this->put(
            sprintf('%s/%s', self::USERS_VALIDATE_ENDPOINT, 'randomtoken')
        );

        $response->assertSuccessful();
        $response->assertJson([
            'id' => 4,
            'email' => 'new.user@example.com',
            'validation_token' => 'randomtoken',
            'user_type_id' => 1,
            'first_validation' => true,
            'user_exist' => true,
        ]);
        $response->assertJsonStructure($this->validationStructure());
    }

    public function testShouldReturn404WhenValidateToken(): void
    {
        $response = $this->put(
            sprintf('%s/%s_invalid', self::USERS_VALIDATE_ENDPOINT, self::REGISTRATION_TOKEN)
        );

        $response->assertStatus(404);
    }

    private function createUserWithDeletedProfile(): void
    {
        $user = User::factory()->createOne([
            'email' => 'new.user@example.com',
        ]);
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'user_type_id' => 1,
        ]);
        $profile->delete();
        TmpUser::factory()->create([
            'email' => 'new.user@example.com',
            'user_id' => $user->id,
            'user_type_id' => 1,
            'validation_token' => 'randomtoken',
            'validated_at' => null,
            'first_validation' => null,
        ]);
    }

    private function validationStructure(): array
    {
        return [
            'id',
            'email',
            'validation_token',
            'validated_at',
            'user_type_id',
            'first_validation',
            'user_exist',
        ];
    }
}
