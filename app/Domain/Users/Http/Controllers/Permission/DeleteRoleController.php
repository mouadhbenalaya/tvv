<?php

namespace App\Domain\Users\Http\Controllers\Permission;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Models\Role;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteRoleController extends Controller
{
    #[Delete(
        path: '/api/v1/permissions/roles/{role}',
        summary: 'Delete role',
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
                example: 1
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
                response: 204,
                description: 'Deleted',
                content: new JsonContent(
                    properties: [
                        new Property(
                            property: 'message',
                            type: 'string',
                            example: 'Role deleted.',
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
    public function __invoke(Role $role): JsonResponse
    {
        //$this->authorize('delete', $role);
        $role->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
