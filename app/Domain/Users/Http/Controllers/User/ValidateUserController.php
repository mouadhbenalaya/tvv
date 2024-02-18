<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Controllers\User;

use App\Common\Http\Controllers\Controller;
use App\Domain\Users\Http\Requests\User\UserValidateRequest;
use App\Domain\Users\Http\Resources\User\TmpUserResource;
use App\Domain\Users\Services\User\ValidateUserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserController extends Controller
{
    public function __construct(
        private readonly ValidateUserService $validateUserService,
    ) {
        $this->middleware('guest');
    }

    #[Put(
        path: '/api/v1/users/validate/{token}',
        summary: 'Validate TmpUser',
        tags: [
            'Users',
        ],
        parameters: [
            new Parameter(
                name: 'token',
                description: 'Token string',
                in: 'path',
                required: true,
                schema: new Schema(
                    type: 'string',
                    example: 'KA5xuYirE0ybUITENmvsQouFGPnWzKMgHcRNyrGlZtoRbxHt2rm2c5amZLxVOGvh',
                ),
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'User created successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/TmpUserResource',
                ),
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
    public function __invoke(UserValidateRequest $request): JsonResponse
    {
        /** @var string $token */
        $token = $request->route('token');

        $tmpUser = $this->validateUserService->createTmpUser($token);
        return response()->json(new TmpUserResource($tmpUser), Response::HTTP_OK);
    }
}
