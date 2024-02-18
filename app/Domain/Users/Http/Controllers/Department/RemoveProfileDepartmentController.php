<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Resources\User\DepartmentResource;
use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\Profile;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class RemoveProfileDepartmentController extends Controller
{
    #[Post(
        path: '/api/v1/departments/{department}/profiles/{profile}/remove',
        summary: 'Remove Profile from Department',
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
            new Parameter(
                name: 'profile',
                description: 'Profile id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Profile removed from department successfully',
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
    public function __invoke(Department $department, Profile $profile): JsonResponse
    {
        //$this->authorize('remove', $profile);

        $profile->department()->dissociate()->save();

        return response()->json(new DepartmentResource($department), Response::HTTP_CREATED);
    }
}
