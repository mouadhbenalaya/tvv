<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Tvtc;

use App\Application\Contracts\UserRepository;
use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Authentication\ResetPasswordRequest;
use App\Domain\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response;

use function __;
use function response;

class SetPasswordController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Put(
        path: '/api/v1/tvtc/set-password/{token}',
        description: 'Update TVTC Operator password',
        summary: 'Update TVTC Operator password',
        requestBody: new RequestBody(
            description: 'Update TVTC Operator password',
            required: true,
            content: new JsonContent(
                required: [
                    'password',
                    'password_confirmation',
                ],
                properties: [
                    new Property(
                        property: 'email',
                        type: 'string',
                        example: 'john.doe@example.com',
                    ),
                    new Property(
                        property: 'password',
                        type: 'string',
                        example: 'secretPassword',
                    ),
                    new Property(
                        property: 'password_confirmation',
                        type: 'string',
                        example: 'secretPassword',
                    ),
                ],
            ),
        ),
        tags: [
            'TVTC',
        ],
        parameters: [
            new Parameter(
                name: 'token',
                description: 'Token string',
                in: 'path',
                required: true,
                schema: new Schema(
                    type:'string',
                    example:'4b3326dd4a37b74c2e05f7e839c86ce7c45693dfa13daff376f791c53d49ddf0',
                ),
            ),
        ],
        responses: [
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
    public function __invoke(ResetPasswordRequest $request): JsonResponse
    {
        $status = $request->changePasswordStatus();
        $code = ($status === Password::PASSWORD_RESET) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;
        if ($code === Response::HTTP_OK) {
            /** @var User $user */
            $user = $this->userRepository->findOneBy([
                'email' => $request->input('email'),
            ]);
            $this->userRepository->update($user, [
               'email_verified_at' => Carbon::now(),
            ]);
        }

        return response()->json(['message' => __($status)], $code);
    }
}
