<?php

namespace App\Domain\Users\Http\Controllers\Permission;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\ProfileResourceForRoles;
use App\Domain\Users\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response;

class RetrieveRolesPerProfileController extends Controller
{
    #[Get(
        path: '/api/v1/users/profiles/{profile}/roles',
        summary: 'List Roles of Profile',
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
                example: 1,
            ),
            new Parameter(
                name: 'locale',
                description: 'Language locale',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    enum: [
                        'en',
                        'ar',
                    ],
                ),
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/ProfileResourceForRoles',
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
    public function __invoke(Request $request, Profile $profile): JsonResponse
    {
        return response()->json(new ProfileResourceForRoles($profile), Response::HTTP_OK);
    }
}
