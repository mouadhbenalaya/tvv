<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Enums\UserType;
use App\Domain\Users\Http\Requests\Authentication\SwapUserRequest;
use App\Domain\Users\Http\Responses\TokenResponse;
use App\Domain\Users\Managers\UserManager;
use App\Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

use function auth;

class SwitchUserController extends Controller
{
    public function __construct(
        private readonly UserManager $userManager
    ) {
    }

    #[Post(
        path: '/api/v1/auth/switch',
        description: 'Switch User Profile by UserType',
        summary: 'Switch User Profile by UserType',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Switch User Profile by UserType',
            required: true,
            content: new JsonContent(
                required: ['user_type_id'],
                properties: [
                    new Property(
                        property: 'user_type_id',
                        type: 'integer',
                        example: 1,
                    ),
                ],
            ),
        ),
        tags: ['Authentication'],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
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
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 403,
                description: 'Forbidden',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(SwapUserRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->currentProfile()?->isTvtcOperator()) {
            $this->userManager->deleteCurrentAccessToken($user);
            return response()->json([], Response::HTTP_CREATED);
        }

        $token = $this->userManager->validateAndCreateTokenByType($user, $request->get('user_type_id'));

        return (new TokenResponse())->json($user, $token);
    }
}
