<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestShow\RequestTransactionResource;

use App\Domain\Requests\Models\RequestTransaction;
use Illuminate\Http\JsonResponse;
use App\Common\Services\SearchService;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Parameter;
use Symfony\Component\HttpFoundation\Response;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;

use function response;

class TransactionsRequestController extends Controller
{
    /**
      * @param SearchService $searchService
      */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }
    #[Get(
        path: '/api/v1/request-transactions/{idRequest}',
        summary: 'Get transactions request by id',
        security: [['sanctum' => []]],
        tags: [
            'Request',
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
                    default: 'DESC',
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
            new Parameter(
                name: 'idRequest',
                description: 'Get request by id',
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
                    ref: '#/components/schemas/RequestTransactionResource',
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

    public function __invoke(DefaultSearchRequest $request, $idRequest): ResourceCollection
    {

        $query = RequestTransaction::query();

        $query = $query->where('request_id', $idRequest);

        $requestTypes = $this->searchService->search($query, $request);



        return  RequestTransactionResource::collection($requestTypes);

    }
}
