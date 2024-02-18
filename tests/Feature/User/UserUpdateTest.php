<?php

declare(strict_types=1);

namespace Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;
    public function testShouldReturn200WithUpdatedUserUsingAllFields(): void
    {
        $userData = $this->getUserUpdateArray();

        $this->applyAuthHeaders('tvtc operator');
        $this->withoutAuthorization();

        $response = $this
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn200WithUpdatedUserUsingSomeFields(): void
    {
        $userData = [
            'second_name' => 'John',
            'birth_date' => '1990-01-01',
        ];

        $this->applyAuthHeaders('tvtc operator');
        $this->withoutAuthorization();

        $response = $this
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn401WhenUpdatingUser(): void
    {
        $userData = $this->getUserUpdateArray();

        $response = $this
            ->putJson(self::USERS_ENDPOINT . $this->user->id, $userData);

        $response->assertStatus(401);
    }

    public function testShouldReturn404WhenUpdatingUser(): void
    {
        $userData = $this->getUserArray();

        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->putJson(self::USERS_ENDPOINT . ((int)$this->user->id + 100), $userData);

        $response->assertStatus(404);
    }
}
