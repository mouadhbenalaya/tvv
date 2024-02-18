<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveUserProfile extends Controller
{
    #[Get(
        path: '/api/v1/auth/profile',
        summary: 'Get current User Profile',
        security: [['sanctum' => []]],
        tags: [
            'Authentication',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/UserResource',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 401,
                description: 'Unauthorized',
            ),
            new \OpenApi\Attributes\Response(
                response: 404,
                description: 'Not found',
            ),
        ],
    )]
    public function __invoke(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        return response()->json(new UserResource($user->load('profiles')), Response::HTTP_OK);
    }
}
