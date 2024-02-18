<?php

namespace App\Domain\Users\Http\Controllers\Permission;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\Permission\RoleResource;
use App\Domain\Users\Http\Resources\Permission\RoleResourceByPermissionObjects;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Parameter;
use Symfony\Component\HttpFoundation\Response;

class RetrieveRoleController extends Controller
{
    #[Get(
        path: '/api/v1/permissions/roles/{role}',
        summary: 'Get role data',
        security: [['sanctum' => []]],
        tags: [
            'Permissions',
        ],
        parameters: [
            new Parameter(
                name: 'role',
                description: 'Role id',
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
                    ref: '#/components/schemas/RoleResource',
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
    public function __invoke(Role $role): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();

        //$this->authorize('view', $profile);

        return response()->json(new RoleResourceByPermissionObjects($role), Response::HTTP_OK);
    }
}
