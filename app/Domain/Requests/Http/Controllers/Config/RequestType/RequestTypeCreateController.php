<?php

namespace App\Domain\Requests\Http\Controllers\Config\RequestType;

use App\Domain\Requests\Http\Resources\RequestTypes\ListRequestTypeResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\RequestTypeRequest;
use App\Domain\Requests\Services\RequestTypeRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class RequestTypeCreateController extends Controller
{
    public function __construct(
        private readonly RequestTypeRegisterService $requestTypeRegisterService,
    ) {
    }

    #[Post(
        path:  '/api/v1/request-types/create',
        summary:'create of request Type ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Register request Type',
            required: true,
            content: new JsonContent(
                required: [
                    'enabled',
                    'title',
                ],
                properties: [

                    new Property(
                        property: 'enabled',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'title',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'title_ar',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'desc_short_ar',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'desc_short_en',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'desc_long_ar',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'desc_long_en',
                        type: 'string',
                        example: 'Doe',
                    ),
                    new Property(
                        property: 'request_category_id',
                        type: 'integer',
                        example: 1,
                    ),

                    new Property(
                        property: 'validator',
                        type: 'boolean',
                        example: 1,
                    ),

                    new Property(
                        property: 'release_version',
                        type: 'string',
                        example: 'V1.1',
                    )

                ],
            ),
        ),
        tags: [
            'Request Type Categories',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Request Type registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/ListRequestTypeResource',
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

    public function __invoke(RequestTypeRequest $request): JsonResponse
    {
        $requestData = $request->all($request->getFields());
        $requestType = $this->requestTypeRegisterService->createRequestType($requestData);

        return response()->json(new ListRequestTypeResource($requestType), Response::HTTP_CREATED);
    }
}
