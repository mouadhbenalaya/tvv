<?php

namespace App\Domain\Requests\Http\Controllers\Config\RequestPermissionRole;

use App\Domain\Requests\Http\Resources\RequestTypes\RequestPermissionRoleResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\RequestPermissionRoleRequest;
use App\Domain\Requests\Services\RequestPermissionRoleRegisterService;


use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class RequestPermissionRoleCreateController extends Controller
{
    public function __construct(
        private readonly RequestPermissionRoleRegisterService $requestPermissionRoleRegisterService,
    ) {
    }

    #[Post(
        path:  '/api/v1/request-permission-role/create',
        summary:'create Request Permission Role',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Register Request Permission Role',
            required: true,
            content: new JsonContent(
                required: [
                    'request_permission_id',
                    'role_id',
                ],
                properties: [

                    new Property(
                        property: 'request_permission_id',
                        type: [],
                        example: [1,2],
                    ),

                    new Property(
                        property: 'role_id',
                        type: 'integer',
                        example: 1,
                    ),


                ],
            ),
        ),
        tags: [
            'Request permission role',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Request Type registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/RequestPermissionRoleResource',
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

    public function __invoke(RequestPermissionRoleRequest $request): JsonResponse
    {


        $requestData = $request->all($request->getFields());
        $listPermissionId = $request->only('request_permission_id')  ;
        $roleId = $request->only('role_id')  ;

        $requestType = $this->requestPermissionRoleRegisterService->create($roleId['role_id'], $listPermissionId ['request_permission_id']);


        return response()->json($requestType, Response::HTTP_OK);
    }
}
