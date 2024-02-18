<?php

declare(strict_types=1);

namespace Feature\User;

use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\TmpUser;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn201WhenRegisterUser(): void
    {
        $response = $this->post(
            self::USERS_REGISTER_ENDPOINT,
            $this->getUserRegisterArray(self::REGISTRATION_TOKEN)
        );

        $response->assertSuccessful();
        $response->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn422WhenRegisterUserWithoutRequiredFields(): void
    {
        $requestData = $this->getUserRegisterArray(self::REGISTRATION_TOKEN);
        $requestData['first_name'] = null;
        $requestData['last_name'] = null;
        $response = $this->post(
            self::USERS_REGISTER_ENDPOINT,
            $requestData
        );

        $response->assertStatus(422);
    }

    public function testShouldReturn201WhenRegisterAnotherUserProfile(): void
    {
        $response = $this->post(
            self::USERS_REGISTER_ENDPOINT,
            [
                'token' => self::REGISTRATION_TOKEN . '_2',
            ],
        );

        $response->assertSuccessful();
        $response->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn422WhenRegisterAnotherUserProfile(): void
    {
        $response = $this->post(
            self::USERS_REGISTER_ENDPOINT,
            [
                'token' => self::REGISTRATION_TOKEN . '_3',
            ],
        );

        $response->assertStatus(422);
    }

    public function testShouldReturn422WhenRegisterUser(): void
    {
        $response = $this->post(
            self::USERS_REGISTER_ENDPOINT,
            $this->getUserRegisterArray('invalidtoken')
        );

        $response->assertStatus(422);
    }
}
