<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Enums\UserType;
use App\Domain\Users\Http\Requests\User\UserRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Services\User\ValidateUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;

use Symfony\Component\HttpFoundation\Response;

use function response;

class UpdateUserController extends Controller
{
    public function __construct(public ValidateUserService $userService)
    {
    }

    #[Put(
        path: '/api/v1/users/{user}',
        summary: 'Update existing user',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Update existing user',
            required: true,
            content: new JsonContent(
                required: [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                ],
                properties: [
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
                        property: 'email',
                        type: 'string',
                        example: 'john.doe@example.com',
                    ),
                    new Property(
                        property: 'mobile_number',
                        type: 'string',
                        example: '09876543210',
                    ),
                    new Property(
                        property: 'birth_date',
                        type: 'string',
                        example: '1990-01-01',
                    ),
                    new Property(
                        property: 'gender',
                        type: 'string',
                        default: 'm',
                    ),
                    new Property(
                        property: 'nationality_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'region_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'city_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'locale',
                        type: 'string',
                        default: 'ar',
                    ),
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'user',
                description: 'User id',
                in: 'path',
                required: true,
                example: 1,
            ),
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
                response: 401,
                description: 'Unauthorized',
            ),
            new \OpenApi\Attributes\Response(
                response: 404,
                description: 'Not found',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(UserRequest $request, User $user): JsonResponse
    {
        /** @var ?Profile $profile */
        $profile = auth()->user()?->currentProfile();

        $this->authorize('update', $profile);

        if ($profile?->isTvtcOperator()) {
            $this->userService->tvtcUserUpdate($user);

            return response()->json(new UserResource($user), Response::HTTP_OK);
        }

        $user->update($request->all());

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }
}
