<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Authentication\LoginRequest;
use App\Domain\Users\Http\Responses\TokenResponse;
use App\Domain\Users\Managers\UserManager;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

use OpenApi\Attributes\Response;

use function auth;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserManager $userManager
    ) {
    }

    #[Post(
        path: '/api/v1/auth/login',
        description: 'Login User by UserType',
        summary: 'Login User by UserType',
        requestBody: new RequestBody(
            description: 'Login User by UserType',
            required: true,
            content: new JsonContent(
                required: [
                    'user_type_id',
                    'email',
                    'password',
                ],
                properties: [
                    new Property(
                        property: 'user_type_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'email',
                        type: 'string',
                        example: 'john.doe@q.agency',
                    ),
                    new Property(
                        property: 'password',
                        type: 'string',
                        example: 'secretPassword',
                    ),
                ],
            ),
        ),
        tags: [
            'Authentication',
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Successful operation',
                content: new JsonContent(
                    properties: [
                        new Property(
                            property: 'token',
                            type: 'string',
                            example: '1|HM3l3TpqlOlOxMwMeFlzaVorpgyR0UFJzlPTHHdA',
                        ),
                        new Property(
                            property: 'token_type',
                            type: 'string',
                            example: 'Bearer',
                        ),
                        new Property(
                            property: 'user',
                            ref: '#/components/schemas/UserResource',
                            type: 'object',
                        ),
                    ],
                ),
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
            new Response(
                response: 403,
                description: 'Forbidden',
            ),
            new Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        /** @var User $user */
        $user = auth()->user();
        $token = $this->userManager->validateAndCreateTokenByType($user, $request->get('user_type_id'));

        return (new TokenResponse())->json($user, $token);
    }
}
