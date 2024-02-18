<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserCreateRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Services\User\RegisterUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    public function __construct(
        private readonly RegisterUserService $userRegisterService,
    ) {
    }

    #[Post(
        path: '/api/v1/users',
        summary: 'Create User',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Create User',
            required: true,
            content: new JsonContent(
                required: [
                    'first_name',
                    'last_name',
                    'id_number',
                    'email',
                    'password',
                    'mobile_number',
                    'password',
                    'lives_in_saudi_arabi',
                    'country_id',
                ],
                properties: [
                    new Property(
                        property: 'first_name',
                        type: 'string',
                        example: 'John',
                    ),
                    new Property(
                        property: 'second_name',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'third_name',
                        type: 'string',
                        example: null,
                    ),
                    new Property(
                        property: 'last_name',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'email',
                        type: 'string',
                        default: 'john.doe@example.com',
                    ),
                    new Property(
                        property: 'id_number',
                        type: 'string',
                        default: '0123456789',
                    ),
                    new Property(
                        property: 'password',
                        type: 'string',
                        example: 'secretPassword',
                    ),
                    new Property(
                        property: 'mobile_number',
                        type: 'string',
                        example: '09876543210',
                    ),
                    new Property(
                        property: 'lives_in_saudi_arabi',
                        type: 'boolean',
                        example: true,
                    ),
                    new Property(
                        property: 'country_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'user_type_id',
                        type: 'integer',
                        example: 1,
                    ),
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'User created successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/UserResource',
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
    public function __invoke(UserCreateRequest $request): JsonResponse
    {
        $user = $this->userRegisterService->createUser(
            $request->all($request->getFields()),
            $request->getUserTypeId()
        );
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
