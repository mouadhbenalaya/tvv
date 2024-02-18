<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\DepartmentResource;
use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class RevokeRoleDepartmentController extends Controller
{
    #[Post(
        path: '/api/v1/departments/{department}/roles/revoke',
        summary: 'Revoke Role from Department',
        requestBody: new RequestBody(
            description: 'Revoke Role from Department',
            required: true,
            content: new JsonContent(
                required: [
                    'role',
                ],
                properties: [
                    new Property(
                        property: 'role',
                        type: 'string',
                        example: 'Admin',
                    ),
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'department',
                description: 'Department id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Role revoked from department successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/DepartmentResource',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(Request $request, Department $department): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();
        //$this->authorize('revokeRole', $profile);

        $department->removeRole($request->input('role'));

        return response()->json(new DepartmentResource($department), Response::HTTP_CREATED);
    }
}
