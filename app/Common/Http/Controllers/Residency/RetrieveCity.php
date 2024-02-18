<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\Residency;

use App\Common\Http\Controllers\Controller;
use App\Common\Http\Resources\Residency\CityResource;
use App\Common\Models\City;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveCity extends Controller
{
    #[Get(
        path: '/api/v1/cities/{city}',
        summary: 'Retrieve City',
        tags: ['Residence'],
        parameters: [
            new Parameter(
                name: 'city',
                description: 'City id',
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
                    ref: '#/components/schemas/CityResource',
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
    public function __invoke(City $city): JsonResponse
    {
        return response()->json(new CityResource($city->load('region')), Response::HTTP_OK);
    }
}
