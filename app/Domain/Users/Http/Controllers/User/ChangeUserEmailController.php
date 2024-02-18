<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Application\Contracts\UserRepository;
use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserEmailChangeRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Notifications\EmailChangeNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;

class ChangeUserEmailController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Put(
        path: '/api/v1/users/{user}/email',
        summary: 'Change User email',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Change User email',
            required: true,
            content: new JsonContent(
                required: [
                    'email',
                ],
                properties: [
                    new Property(
                        property: 'email',
                        type: 'string',
                        example: 'john.doe@example.com',
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
                response: 200,
                description: 'User updated successfully',
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
    public function __invoke(User $user, UserEmailChangeRequest $request): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();

        $this->authorize('update', $profile);

        try {
            Notification::send($user, new EmailChangeNotification());
        } catch (TransportException) {
            return response()->json(['error' => __('exception.email.send')], Response::HTTP_REQUEST_TIMEOUT);
        }

        $user = $this->userRepository->update($user, [
            'email' => $request->get('email'),
        ]);
        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
