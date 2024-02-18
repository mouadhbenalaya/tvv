<?php

declare(strict_types=1);

namespace Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCheckTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn200WhenCheckIfUserWithTypeExists(): void
    {
        $userData['email'] = 'user@q.agency';
        $userData['user_type_id'] = $this->userType->id;

        $response = $this->postJson(self::USERS_CHECK_ENDPOINT, $userData);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'user_exist',
        ]);
    }

    public function testShouldReturn422WhenCheckIfUserWithTypeExists(): void
    {
        $userData['email'] = 'user@q.agency';
        $userData['user_type_id'] = $this->lastUserType->id + 100;

        $response = $this->postJson(self::USERS_CHECK_ENDPOINT, $userData);

        $response->assertStatus(422);
    }
}
