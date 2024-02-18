<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Authentication;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Authentication\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Password;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

use function __;
use function response;

class ForgotPassword extends Controller
{
    #[Post(
        path: '/api/v1/auth/reset-password',
        summary: 'Send password reset link to User',
        requestBody: new RequestBody(
            description: 'Send password reset link to User',
            required: true,
            content: new JsonContent(
                required: [
                    'email',
                ],
                properties: [
                    new Property(
                        property: 'email',
                        type: 'string',
                        example: 'john.doe@q.agency',
                    ),
                ],
            ),
        ),
        tags: [
            'Authentication',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Password reset link sent successfully',
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
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        $status = $request->emailLinkStatus();
        $code = ($status === Password::RESET_LINK_SENT) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;

        return response()->json(['message' => __($status)], $code);
    }
}
