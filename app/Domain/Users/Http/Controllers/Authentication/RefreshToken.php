<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Responses\TokenResponse;
use App\Domain\Users\Managers\UserManager;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

use function auth;
use function response;

class RefreshToken extends Controller
{
    public function __construct(
        private readonly UserManager $userManager
    ) {
    }

    #[Post(
        path: '/api/v1/auth/refresh-token',
        description: 'Refresh Token for current User Profile for all devices',
        summary: 'Refresh Token for current User Profile for all devices',
        security: [['sanctum' => []]],
        tags: [
            'Authentication',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Successful operation',
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 401,
                description: 'Unauthenticated',
            ),
            new \OpenApi\Attributes\Response(
                response: 403,
                description: 'Forbidden',
            ),
        ],
    )]
    public function __invoke(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();

        /** @var int $userTypeId */
        $userTypeId = $user->currentProfile()?->userType?->id;
        $token = $this->userManager->validateAndCreateTokenByType(
            user: $user,
            userTypeId: $userTypeId
        );

        return (new TokenResponse())->json($user, $token);
    }
}
