<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\RequestType;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestTypes\ListRequestTypeResource;
use App\Domain\Requests\Models\RequestCategory;
use App\Domain\Requests\Models\RequestType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveRequestTypeController extends Controller
{
    #[Get(
        path: '/api/v1/request-types/{requestType}',
        summary: 'Get single request Type data',
        security: [['sanctum' => []]],
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
                response: 200,
                description: 'Success',
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
        ],
    )]
    public function __invoke(RequestType $requestType): JsonResponse
    {
        $data['data'] = new ListRequestTypeResource($requestType);
        $listCategory  = RequestCategory::select("title_ar as title", 'id')->get() ;
        $data["listCategory"] = $listCategory ;
        return response()->json($data, Response::HTTP_OK);
    }
}
