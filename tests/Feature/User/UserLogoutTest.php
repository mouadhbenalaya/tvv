<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shouldReturn200WhenUserLogsOut(): void
    {
        $this->user->createToken('trainee');
        $this->user->createToken('investor');

        $this->assertEquals(2, $this->user->tokens()->count());
        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::LOGOUT_USER, []);

        $response->assertStatus(200);
        $this->assertEquals(0, $this->user->tokens()->count());
    }

    #[Test]
    public function shouldReturn401WhenUnauthorizedUserTriesToLogout(): void
    {
        $response = $this
            ->postJson(self::LOGOUT_USER, []);

        $response->assertStatus(401);
        $this->assertEquals('Unauthorized', $response->statusText());
    }
}
