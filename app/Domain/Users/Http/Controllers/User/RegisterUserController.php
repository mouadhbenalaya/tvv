<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Services\User\RegisterUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;

class RegisterUserController extends Controller
{
    public function __construct(
        private readonly RegisterUserService $userRegisterService,
    ) {
        $this->middleware('guest');
    }

    #[Post(
        path: '/api/v1/users/register',
        summary: 'Register User',
        requestBody: new RequestBody(
            description: 'Register User',
            required: true,
            content: new JsonContent(
                required: [
                    'token',
                    'first_name',
                    'last_name',
                    'id_number',
                    'password',
                    'mobile_number',
                    'lives_in_saudi_arabi',
                    'country_id',
                ],
                properties: [
                    new Property(
                        property: 'token',
                        type: 'string',
                        example: 'YtHjLdzT4td9xyaTNCbDoW7XAdKYnGsZA6yvvpyWEKA090Yxc35clSgZJDaHirsO',
                    ),
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
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'User registered successfully',
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
    public function __invoke(UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $requestData = $request->all($request->getFields());
            $user = $this->userRegisterService->createUser($requestData);
        } catch (TransportException) {
            DB::rollBack();

            return response()->json(['error' => __('exception.email.send')], Response::HTTP_OK);
        }
        DB::commit();

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
