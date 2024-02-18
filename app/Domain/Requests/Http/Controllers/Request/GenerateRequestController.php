<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestTypes\RequestTypeResource;
use App\Domain\Requests\Models\RequestType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

use Symfony\Component\HttpFoundation\Response;

use function response;

class GenerateRequestController extends Controller
{
    #[Get(
        path: '/api/v1/generate-from/{requestType}',
        summary: 'Get single request Type data',
        security: [['sanctum' => []]],
        tags: [
            'Generate from',
        ],
        parameters: [

            new Parameter(
                name: 'locale',
                description: 'Language locale',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    enum: [
                        'en',
                        'ar',
                    ],
                ),
            ),
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
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/RequestTypeResource',
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
        ],
    )]
    public function __invoke(RequestType $requestType): JsonResponse
    {

        return response()->json(new RequestTypeResource($requestType), Response::HTTP_OK);
    }
}
