<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Department;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteDepartmentController extends Controller
{
    #[Delete(
        path: '/api/v1/departments/{department}',
        summary: 'Delete department',
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
                            example: 'Department deleted.',
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
    public function __invoke(Department $department): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();
        //$this->authorize('delete', $profile);

        $this->authorize('delete', $department);
        $department->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
