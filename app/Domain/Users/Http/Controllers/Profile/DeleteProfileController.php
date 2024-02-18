<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Profile;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Models\Profile;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteProfileController extends Controller
{
    #[Delete(
        path: '/api/v1/users/profiles/{profile}',
        summary: 'Delete user',
        security: [['sanctum' => []]],
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'profile',
                description: 'Profile id',
                in: 'path',
                required: true,
                example: 1
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 204,
                description: 'Deleted',
                content: new JsonContent(
                    properties: [
                        new Property(
                            property: 'message',
                            type: 'string',
                            example: 'User profile deleted.',
                        ),
                    ],
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
    public function __invoke(Profile $profile): JsonResponse
    {
        $this->authorize('delete', $profile);
        $profile->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
