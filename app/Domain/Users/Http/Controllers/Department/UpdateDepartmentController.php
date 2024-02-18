<?php

namespace App\Domain\Users\Http\Controllers\Department;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Permission\RoleRequest;
use App\Domain\Users\Http\Requests\User\DepartmentRequest;
use App\Domain\Users\Http\Resources\Permission\RoleResource;
use App\Domain\Users\Http\Resources\User\DepartmentResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use App\Domain\Users\Models\Department;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class UpdateDepartmentController extends Controller
{
    #[Put(
        path: '/api/v1/departments/{department}',
        summary: 'Update Department',
        requestBody: new RequestBody(
            description: 'Update Department',
            required: true,
            content: new JsonContent(
                required: [
                    'name',
                ],
                properties: [
                    new Property(
                        property: 'name',
                        type: 'string',
                        example: 'Admin',
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
                description: 'Department updated successfully',
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
    public function __invoke(DepartmentRequest $request, Department $department): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();
        //$this->authorize('update', $profile);

        $department->update([
            'name' => $request->input('name')
        ]);

        return response()->json(new DepartmentResource($department), Response::HTTP_CREATED);
    }
}
