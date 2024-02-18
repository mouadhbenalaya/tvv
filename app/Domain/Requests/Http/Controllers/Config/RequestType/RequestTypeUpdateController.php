<?php

namespace App\Domain\Requests\Http\Controllers\Config\RequestType;

use App\Domain\Requests\Http\Resources\RequestTypes\ListRequestTypeResource;
use App\Domain\Requests\Http\Requests\RequestTypeRequest;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\RequestCategory;
use App\Domain\Requests\Models\RequestType;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;

class RequestTypeUpdateController extends Controller
{
    #[Put(
        path:  '/api/v1/request-types/{requestType}',
        summary:'Update existing request Type ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Update existing request Type',
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
        parameters: [
            new Parameter(
                name: 'requestType',
                description: 'requestType id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'User created successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/ListRequestTypeResource',
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
    public function __invoke(RequestTypeRequest $request, RequestType $requestType): JsonResponse
    {

        $requestType->update($request->all());
        $data['data'] = new ListRequestTypeResource($requestType);
        $listCategory  = RequestCategory::select("title_ar as title", 'id')->get() ;
        $data["listCategory"] = $listCategory ;
        return response()->json($data, Response::HTTP_OK);
    }
}
