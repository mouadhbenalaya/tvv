<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserCheckRequest;
use App\Domain\Users\Notifications\Registration\UserCannotRegister;
use App\Domain\Users\Notifications\Registration\UserEmailConfirmation;
use App\Domain\Users\Services\User\CheckUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;

class CheckUserController extends Controller
{
    public function __construct(
        private readonly CheckUserService $userService,
    ) {
        $this->middleware('guest');
    }

    #[Post(
        path: '/api/v1/users/check',
        summary: 'Check if User exists and create TmpUser',
        requestBody: new RequestBody(
            description: 'Check if User exists and create TmpUser',
            required: true,
            content: new JsonContent(
                required: [
                    'email',
                    'user_type',
                ],
                properties: [
                    new Property(
                        property: 'email',
                        type: 'string',
                        default: 'john.doe@q.agency',
                    ),
                    new Property(
                        property: 'user_type_id',
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
                response: 200,
                description: 'User check completed',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(UserCheckRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $requestData = $request->all([
                'email',
                'user_type_id',
            ]);
            $existingUser = $this->userService->getExistingUser($requestData);
            $userExist = false;
            try {
                $tmpUser = $this->userService->createTmpUser($existingUser, $requestData);
                Notification::send($tmpUser, new UserEmailConfirmation($tmpUser->validation_token));
            } catch (ValidationException $validationException) {
                $userExist = (bool)$validationException->validator->errors()->first('user_exist');
                Notification::send($existingUser, new UserCannotRegister());
            }
        } catch (TransportException) {
            DB::rollBack();

            return response()->json(['error' => __('exception.email.send')], Response::HTTP_OK);
        }
        DB::commit();

        return response()->json(['user_exist' => $userExist], Response::HTTP_OK);
    }
}
