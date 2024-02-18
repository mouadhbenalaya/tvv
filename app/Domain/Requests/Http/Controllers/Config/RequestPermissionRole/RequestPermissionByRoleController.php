<?php

namespace App\Domain\Requests\Http\Controllers\Config\RequestPermissionRole;

use Symfony\Component\HttpFoundation\Response;
use App\Common\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Services\SearchService;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Requests\Http\Resources\RequestTypes\RequestPermissionResource;
use App\Domain\Requests\Http\Resources\RequestTypes\RequestPermissionRoleResource;
use App\Domain\Requests\Models\RequestPermission;
use App\Domain\Requests\Models\RequestPermissionRole;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;

class RequestPermissionByRoleController extends Controller
{
    /**
      * @param SearchService $searchService
      */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/request-permission-role/get',
        summary:'get Request Permission Role',
        security: [['sanctum' => []]],
        tags: [
            'Request permission role',
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
                name: 'role',
                description: 'Get List Request Permission Role by role',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'integer',
                ),
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/ListRequestTypeResource',
                    ),
                ),
            ),

            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request, Request $currentRequest): ResourceCollection
    {


        $roleId = $currentRequest->query->get('role');
        if (null !== $roleId) {
            $query = RequestPermissionRole::query();

            $query = $query->with('requestPermission')->where('role_id', $roleId);

            $requestTypes = $this->searchService->search($query, $request);


            return  RequestPermissionRoleResource::collection($requestTypes);
        } else {

            $query = RequestPermission::query();

            $requestTypes = $this->searchService->search($query, $request);

            return  RequestPermissionResource::collection($requestTypes);

        }



    }


}
