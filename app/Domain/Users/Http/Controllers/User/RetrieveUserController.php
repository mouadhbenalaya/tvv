<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveUserController extends Controller
{
    #[Get(
        path: '/api/v1/users/{user}',
        summary: 'Get user data',
        security: [['sanctum' => []]],
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'user',
                description: 'User id',
                in: 'path',
                required: true,
                example: 1,
            ),
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
    public function __invoke(User $user): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();

        $this->authorize('view', $profile);

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }
}
