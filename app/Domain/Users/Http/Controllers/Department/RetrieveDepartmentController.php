<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\Permission\RoleResource;
use App\Domain\Users\Http\Resources\User\DepartmentResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\Department;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use Symfony\Component\HttpFoundation\Response;

class RetrieveDepartmentController extends Controller
{
    #[Get(
        path: '/api/v1/departments/{department}',
        summary: 'Get department data',
        security: [['sanctum' => []]],
        tags: [
            'Departments',
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
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/DepartmentResource',
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
    public function __invoke(Department $department): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();
        //$this->authorize('view', $profile);

        return response()->json(new DepartmentResource($department), Response::HTTP_OK);
    }
}
