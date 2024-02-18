<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\DepartmentRequest;
use App\Domain\Users\Http\Resources\User\DepartmentResource;
use App\Domain\Users\Models\Department;
use App\Domain\Users\Models\Profile;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class CreateDepartmentController extends Controller
{
    #[Post(
        path: '/api/v1/departments',
        summary: 'Create Department',
        requestBody: new RequestBody(
            description: 'Create Department',
            required: true,
            content: new JsonContent(
                required: [
                    'name',
                ],
                properties: [
                    new Property(
                        property: 'name',
                        type: 'string',
                        example: 'Security Operations',
                    ),
                ],
            ),
        ),
        tags: [
            'Departments',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Department created successfully',
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
    public function __invoke(DepartmentRequest $request): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();
        //$this->authorize('create', $profile);

        $department = Department::firstOrCreate([
            'name' => $request->input('name'),
        ]);

        return response()->json(new DepartmentResource($department), Response::HTTP_CREATED);
    }
}
