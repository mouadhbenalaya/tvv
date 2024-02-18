<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\Residency;

use App\Common\Http\Controllers\Controller;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Common\Http\Resources\Residency\CityResource;
use App\Common\Models\City;
use App\Common\Services\SearchService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Request;

class RetrieveCityCollection extends Controller
{
    /**
     * @param SearchService $searchService
     */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/cities',
        summary: 'Get list of SA cities',
        tags: ['Residence'],
        parameters: [
            new Parameter(
                name: 'region_id',
                description: 'Filter cities by region',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'query',
                description: 'Enter the query string to search for (will search all string fields of the entity)',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'orderBy',
                description: 'Sort by this field name',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: 'id',
                ),
            ),
            new Parameter(
                name: 'direction',
                description: 'Sorting direction - ASC or DESC',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: 'ASC',
                ),
            ),
            new Parameter(
                name: 'paginate',
                description: 'Active or inactive users - true or false',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'boolean',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'page',
                description: 'Enter the page number to show',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: '1',
                ),
            ),
            new Parameter(
                name: 'limit',
                description: 'Enter the number of result items to show on a page',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: '10',
                ),
            ),
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
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/CityResource',
                    ),
                ),
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request, Request $currentRequest): ResourceCollection
    {
        $query = City::query();
        $regionId = $currentRequest->query->get('region_id');
        if (null !== $regionId) {
            $query = $query->where('region_id', $regionId);
        }

        $cities = $this->searchService->search($query, $request);

        return CityResource::collection($cities);
    }
}
