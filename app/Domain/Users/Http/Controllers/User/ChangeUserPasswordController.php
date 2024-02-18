<?php

namespace App\Domain\Users\Http\Controllers\User;

use App\Application\Contracts\UserRepository;
use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserEmailChangeRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Models\User;
use App\Domain\Users\Notifications\EmailChangeNotification;
use App\Domain\Users\Notifications\PasswordChangeNotification;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;

class ChangeUserPasswordController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Post(
        path: '/api/v1/users/password-change',
        summary: 'Change User password',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Change User password',
            required: true,
            content: new JsonContent(
                required: [
                    'email',
                    'password',
                    'password_confirmation'
                ],
                properties: [
                    new Property(
                        property: 'current_password',
                        type: 'string',
                        example: 'password123',
                    ),
                    new Property(
                        property: 'password',
                        type: 'string',
                        example: 'password456',
                    ),
                    new Property(
                        property: 'password_confirmation',
                        type: 'string',
                        example: 'password456',
                    ),
                ],
            ),
        ),
        tags: [
            'Users',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'User password updated successfully',
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
    public function __invoke(UserEmailChangeRequest $request): JsonResponse
    {
        ///** @var Profile $profile */
        //$profile = auth()->user()?->currentProfile();

        //$this->authorize('update', $profile);

        /** @var User $user */
        $user = \Auth::user();

        if ($user !== null) {
            if (!Hash::check($request->input('current_password'), (string) $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 400);
            }

            try {
                Notification::send($user, new PasswordChangeNotification());
            } catch (TransportException) {
                return response()->json(['error' => __('exception.email.send')], Response::HTTP_REQUEST_TIMEOUT);
            }

            $user->update(['password' => $request->password]);
        }

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
