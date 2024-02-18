<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\Residency;

use App\Common\Http\Controllers\Controller;
use App\Common\Http\Resources\Residency\CountryResource;
use App\Common\Models\Country;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveCountry extends Controller
{
    #[Get(
        path: '/api/v1/countries/{country}',
        summary: 'Retrieve Country',
        tags: ['Residence'],
        parameters: [
            new Parameter(
                name: 'country',
                description: 'Country id',
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
                    ref: '#/components/schemas/CountryResource',
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
    public function __invoke(Country $country): JsonResponse
    {
        return response()->json(new CountryResource($country), Response::HTTP_OK);
    }
}
