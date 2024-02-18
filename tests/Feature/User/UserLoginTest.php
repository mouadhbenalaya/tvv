<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Domain\Users\Models\Profile;
use Database\Factories\Domain\Users\Models\ProfileFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shouldReturn201WhenUserTriesToLogIn(): void
    {
        /** @var Profile $profile */
        $profile = ProfileFactory::new()->forUser($this->user)->investor()->create();

        $data = [
            'email' => $this->user->email,
            'password' => 'secretPassword',
            'user_type_id' =>  $profile->userType->id,
        ];

        $response = $this->postJson(self::LOGIN_USER, $data);

        $response->assertStatus(201);
        $this->assertNotEmpty($response->json('token'));
    }


    public static function wrongLoginData(): array
    {
        return [
            ['secretPassword1', 61],
            ['secretPass1', 856]
        ];
    }

    #[
        Test,
        DataProvider('wrongLoginData')
    ]
    public function shouldReturn422WhenUserTriesToLogIn(string $password, int $userTypeId): void
    {
        $data = [
            'email' => $this->user->email,
            'password' => $password,
            'user_type_id' => $userTypeId,
        ];

        $response = $this->postJson(self::LOGIN_USER, $data);

        $response->assertStatus(422);
        $this->assertEmpty($response->json('token'));
    }
}
