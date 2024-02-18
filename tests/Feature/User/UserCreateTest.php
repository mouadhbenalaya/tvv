<?php

declare(strict_types=1);

namespace Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn201WhenCreateUser(): void
    {
        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->post(self::USERS_CREATE_ENDPOINT, $this->getUserCreateArray());

        $response->assertSuccessful();
        $response->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn422WhenCreateUserWithoutRequiredFields(): void
    {
        $requestData = $this->getUserCreateArray();
        $requestData['first_name'] = null;
        $requestData['last_name'] = null;

        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->post(self::USERS_CREATE_ENDPOINT, $requestData);

        $response->assertStatus(422);
    }

    public function testShouldReturn403WhenCreateUser(): void
    {
        $response = $this->post(self::USERS_CREATE_ENDPOINT, $this->getUserCreateArray());

        $response->assertStatus(403);
    }
}
