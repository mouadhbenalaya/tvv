<?php

declare(strict_types=1);

namespace Feature\Profile;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldReturn204WhenDeletingUser(): void
    {
        $this->applyAuthHeaders('tvtc operator');
        $this->withoutAuthorization();

        $response = $this
            ->deleteJson(self::USERS_PROFILE_ENDPOINT . $this->profile->id);

        $response->assertStatus(204);
    }

    public function testShouldReturn403WhenDeletingUser(): void
    {
        $this->applyAuthHeaders('trainee');

        $response = $this
            ->deleteJson(self::USERS_PROFILE_ENDPOINT . $this->users->last()->profiles()->first()->id);

        $response->assertStatus(403);
    }

    public function testShouldReturn401WhenDeletingUser(): void
    {
        $response = $this
            ->deleteJson(self::USERS_PROFILE_ENDPOINT . $this->profile->id);

        $response->assertStatus(401);
    }

    public function testShouldReturn404WhenDeletingUser(): void
    {
        $nonExistingId = (int)$this->profile->id + 100;

        $this->applyAuthHeaders('tvtc operator');

        $response = $this
            ->deleteJson(self::USERS_PROFILE_ENDPOINT . $nonExistingId);

        $response->assertStatus(404);
    }
}
