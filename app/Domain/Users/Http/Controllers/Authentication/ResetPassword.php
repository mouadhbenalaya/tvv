<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Authentication\ResetPasswordRequest;
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

class ResetPassword extends Controller
{
    #[Put(
        path: '/api/v1/auth/reset-password/{token}',
        description: 'Update User password',
        summary: 'Update User password',
        requestBody: new RequestBody(
            description: 'Update User password',
            required: true,
            content: new JsonContent(
                required: [
                    'email',
                    'password',
                    'password_confirmation',
                ],
                properties: [
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
                    new Property(
                        property: 'password_confirmation',
                        type: 'string',
                        example: 'secretPassword',
                    ),
                ],
            ),
        ),
        tags: [
            'Authentication',
        ],
        parameters: [
            new Parameter(
                name: 'token',
                description: 'Token string',
                in: 'path',
                required: true,
                schema: new Schema(
                    type:'string',
                    example:'1|HM3l3TpqlOlOxMwMeFlzaVorpgyR0UFJzlPTHHdA',
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

        return response()->json(['message' => __($status)], $code);
    }
}
