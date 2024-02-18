<?php

declare(strict_types=1);

namespace App\Common\Http\Controllers\AuditLog;

use App\Application\Contracts\AuditLogRepository;
use App\Common\Http\Controllers\Controller;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Common\Http\Resources\AuditLogResource;
use App\Common\Services\SearchService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Request;

class RetrieveAuditLogCollection extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly AuditLogRepository $auditLogRepository,
    ) {
    }

    #[Get(
        path: '/api/v1/audit-logs',
        summary: 'Get AuditLog collection',
        security: [['sanctum' => []]],
        tags: ['AuditLog'],
        parameters: [
            new Parameter(
                name: 'auditable_type',
                description: 'Filter AuditLog by type',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'auditable_id',
                description: 'Filter AuditLog by id',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'event',
                description: 'Filter AuditLog by event',
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
        ],
        responses: [
            new Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/AuditLogResource',
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
        $query = $this->auditLogRepository->prepareQueryWithFilters(
            $currentRequest->get('auditable_type'),
            $currentRequest->get('auditable_id'),
            $currentRequest->get('event'),
        );

        $auditLogs = $this->searchService->search($query, $request);

        return AuditLogResource::collection($auditLogs);
    }
}
