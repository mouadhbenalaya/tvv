<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\Tvtc;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\Tvtc\TvtcCreateOperatorRequest;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Domain\Users\Models\Profile;
use App\Domain\Users\Services\User\TvtcUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;

class CreateTvtcOperatorController extends Controller
{
    public function __construct(
        private readonly TvtcUserService $tvtcUserService,
    ) {
    }

    #[Post(
        path: '/api/v1/tvtc',
        summary: 'Create TVTC Operator',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Create TVTC Operator',
            required: true,
            content: new JsonContent(
                required: [
                    'first_name',
                    'last_name',
                    'id_number',
                    'email',
                    'ad_user_name',
                    'department_id',
                    'lives_in_saudi_arabi',
                    'country_id',
                    'mobile_number',
                ],
                properties: [
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
                        property: 'email',
                        type: 'string',
                        default: 'john.doe@example.com',
                    ),
                    new Property(
                        property: 'id_number',
                        type: 'string',
                        default: '0123456789',
                    ),
                    new Property(
                        property: 'ad_user_name',
                        type: 'string',
                        example: 'ad_user_name',
                    ),
                    new Property(
                        property: 'department_id',
                        type: 'integer',
                        example: 1,
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
            'TVTC',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'User created successfully',
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
    public function __invoke(TvtcCreateOperatorRequest $request): JsonResponse
    {
        /** @var Profile $profile */
        $profile = auth()->user()?->currentProfile();

        //$this->authorize('create', $profile);

        try {
            DB::beginTransaction();
            $user = $this->tvtcUserService->createUser(
                $request->all($request->getUserFields()),
                $request->getProfileData(),
            );
        } catch (TransportException) {
            DB::rollBack();

            return response()->json(['error' => __('exception.email.send')], Response::HTTP_OK);
        }
        DB::commit();

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }
}
