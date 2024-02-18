<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\Residency;

use App\Common\Http\Controllers\Controller;
use App\Common\Http\Resources\Residency\RegionResource;
use App\Common\Models\Region;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveRegion extends Controller
{
    #[Get(
        path: '/api/v1/regions/{region}',
        summary: 'Retrieve Region',
        tags: ['Residence'],
        parameters: [
            new Parameter(
                name: 'region',
                description: 'Region id',
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
                    ref: '#/components/schemas/RegionResource',
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
    public function __invoke(Region $region): JsonResponse
    {
        return response()->json(new RegionResource($region->load('cities')), Response::HTTP_OK);
    }
}
