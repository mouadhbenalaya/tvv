<?php

namespace App\Domain\Users\Http\Controllers\Permission;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Services\RequestPermissionRoleRegisterService;
use App\Domain\Users\Http\Requests\Permission\RoleRequest;
use App\Domain\Users\Http\Requests\User\UserRequest;
use App\Domain\Users\Http\Resources\Permission\RoleResource;
use App\Domain\Users\Http\Resources\Permission\RoleResourceByPermissionObjects;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Permission;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\Role;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Parameter;

class CreateRoleController extends Controller
{
    public function __construct(
        private readonly RequestPermissionRoleRegisterService $requestPermissionRoleRegisterService,
    ) {
    }
    #[Post(
        path: '/api/v1/permissions/roles',
        summary: 'Create Role',
        security: [['sanctum' => []]],
        parameters: [

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
        requestBody: new RequestBody(
            description: 'Create Role',
            required: true,
            content: new JsonContent(
                required: [
                    'name',
                    'description',
                ],
                properties: [

                    new Property(
                        property: 'name',
                        type: 'string',
                        example: 'Admin',
                    ),
                    new Property(
                        property: 'name_ar',
                        type: 'string',
                        example: 'Admin',
                    ),
                    new Property(
                        property: 'department_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'user_type',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'description',
                        type: 'string',
                        example: 'some role description',
                    ),
                    new Property(
                        property: 'service_permission',
                        type: [],
                        example: [1,2],
                    ),
                    new Property(
                        property: 'permissions',
                        type: [],
                        example: [1,2],
                    ),

                ],
            ),
        ),
        tags: [
            'Permissions',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Role created successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/RoleResource',
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
    public function __invoke(RoleRequest $request): JsonResponse
    {

        $role = Role::firstOrCreate([
           'name' => $request->input('name'),
           'name_ar' => $request->input('name_ar') ?? null,
           'user_type_id' => $request->input('user_type') ?? null,
           'department_id' => $request->input('department_id'),
           'description' => $request->input('description'),
        ]);

        if ($request->has('permissions')) {
            foreach ($request->input('permissions') as $permission_id) {
                $role->givePermissionTo(Permission::where('id', $permission_id)->pluck('name'));
            }
        }
        if($role->requestPermissionRoles()) {
            $role->requestPermissionRoles()->delete() ;
        }

        $listPermissionId = $request->only('service_permission')  ;
        /**   add service_permission */
        if ($request->has('service_permission') and !empty($listPermissionId)) {



            $this->requestPermissionRoleRegisterService->create($role->id, $listPermissionId ['service_permission']);

        }

        return response()->json(new RoleResourceByPermissionObjects($role), Response::HTTP_CREATED);
    }
}
