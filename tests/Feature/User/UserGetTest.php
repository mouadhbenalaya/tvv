<?php

declare(strict_types=1);

namespace Feature\User;

use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserGetTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn200WhenGetProfile(): void
    {
        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->getJson(self::USER_PROFILE_ENDPOINT);

        $response->assertStatus(200);
        $response->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn200WithSingleUser(): void
    {
        $this->applyAuthHeaders('tvtc operator');
        $this->withoutAuthorization();

        $response = $this
            ->getJson(self::USERS_ENDPOINT . $this->user->id);

        $response->assertStatus(200)
            ->assertJsonStructure($this->userStructure());
    }

    public function testShouldReturn404IfUserDoesntExists(): void
    {
        $nonExistingId = (int)$this->user->id + 100;

        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->getJson(self::USERS_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }

    public function testShouldReturn401OnGetUser(): void
    {
        $response = $this
            ->getJson(self::USERS_ENDPOINT . $this->user->id);

        $response->assertStatus(401);
    }

    public function testShouldReturn200WithCollectionOfUsers(): void
    {
        $this->applyAuthHeaders('tvtc operator');
        $this->withoutAuthorization();

        $response = $this
            ->getJson(self::USERS_ENDPOINT);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->userStructure(),
                ],
            ]);
    }

    public function testShouldReturn401WhenTryingToGetUserCollection(): void
    {
        $response = $this
            ->getJson(self::USERS_ENDPOINT);

        $response->assertStatus(401);
    }
}
