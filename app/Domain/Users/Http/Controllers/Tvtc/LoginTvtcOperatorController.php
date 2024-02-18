<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Tvtc;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Tvtc\TvtcLoginOperatorRequest;
use App\Domain\Users\Http\Responses\TokenResponse;
use App\Domain\Users\Models\User;
use App\Domain\Users\Services\User\TvtcLoginUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;

class LoginTvtcOperatorController extends Controller
{
    public function __construct(
        private readonly TvtcLoginUserService $tvtcLoginUserService,
    ) {
    }

    #[Post(
        path: '/api/v1/tvtc/login',
        summary: 'Login TVTC Operator',
        requestBody: new RequestBody(
            description: 'Login TVTC Operator',
            required: true,
            content: new JsonContent(
                required: [
                    'id_number',
                    'password',
                ],
                properties: [
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
                ],
            ),
        ),
        tags: [
            'TVTC',
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
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(TvtcLoginOperatorRequest $request): JsonResponse
    {
        $token = $this->tvtcLoginUserService->loginUser(
            $request->input('id_number'),
            $request->input('password'),
        );
        /** @var User $user */
        $user = \auth()->user();

        return (new TokenResponse())->json($user, $token);
    }
}
