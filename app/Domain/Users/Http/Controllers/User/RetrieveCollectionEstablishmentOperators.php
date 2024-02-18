<?php

namespace App\Domain\Users\Http\Controllers\User;

use App\Application\Repositories\EloquentProfileRepository;
use App\Common\Http\Controllers\Controller;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Common\Services\SearchService;
use App\Domain\Users\Http\Resources\User\InvestorProfileResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;

class RetrieveCollectionEstablishmentOperators extends Controller
{
    /**
     * @param SearchService $searchService
     */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/users/establishment-operators',
        summary: 'Get list of establishment operators',
        security: [['sanctum' => []]],
        tags: [
            'Users',
        ],
        parameters: [
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
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/UserResource',
                    ),
                ),
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
            new Response(
                response: 401,
                description: 'Unauthorized',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request): ResourceCollection
    {
        $profiles = $this->searchService->search(EloquentProfileRepository::establishmentProfiles(), $request);
        return InvestorProfileResource::collection($profiles);
    }
}
