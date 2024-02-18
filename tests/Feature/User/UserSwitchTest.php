<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Domain\Users\Models\Profile;
use Database\Factories\Domain\Users\Models\ProfileFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserSwitchTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shouldReturn201WhenUserTriesToSwitch(): void
    {
        /** @var Profile $profile */
        $profile = ProfileFactory::new()->forUser($this->user)->investor()->create();
        $data = ['user_type_id' => $profile->userType->id];

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::SWITCH_USER, $data);

        $response->assertStatus(201);
        $this->assertNotEmpty($response->json('token'));
    }

    #[Test]
    public function shouldReturn422WhenUserTriesToSwitch(): void
    {
        $data = ['user_type_id' => 44];

        $response = $this
            ->actingAs($this->user, 'sanctum')
            ->postJson(self::SWITCH_USER, $data);

        $response->assertStatus(422);
        $this->assertEmpty($response->json('token'));
    }
}
