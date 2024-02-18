<?php

namespace App\Domain\Requests\Http\Controllers\Config\RequestType;

use App\Domain\Requests\Http\Resources\RequestTypes\RequestTypeCategoryResource;

use Symfony\Component\HttpFoundation\Response;
use App\Common\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Services\SearchService;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Requests\Models\RequestCategory;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;

class RequestTypeCategoriesController extends Controller
{
    /**
      * @param SearchService $searchService
      */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/request-types/categories',
        summary: 'Get list categories of request Types',
        security: [['sanctum' => []]],
        tags: [
            'Request Type Categories',
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
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    type: 'array',
                    items: new Items(
                        ref: '#/components/schemas/RequestTypeCategoryResource',
                    ),
                ),
            ),

            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request): ResourceCollection
    {
        // Get list Id Role by User Current
        $arrayIdRole =  auth()->user()?->currentProfile()->roles->pluck("id") ->toArray();


        // Get list Id request_types by role and  request_permissions
        $requestTypeIds =  \DB::table('request_categorys')
        ->select('request_categorys.id')
        ->join('request_types', 'request_types.request_category_id', '=', 'request_categorys.id')
        ->join('template_steps', 'template_steps.request_type_id', '=', 'request_types.id')
            ->join('request_permissions', 'template_steps.request_permission_id', '=', 'request_permissions.id')
            ->join('request_permission_role', 'request_permission_role.request_permission_id', '=', 'request_permissions.id')
            ->whereIn('request_permission_role.role_id', $arrayIdRole)
            ->where('template_steps.step_sequence', 1)
            ->get() ->toArray();

        $requestTypeIds = array_column($requestTypeIds, 'id');


        $query = RequestCategory::query();


        $query =   $query ->WhereIn('id', $requestTypeIds) ;

        $RequestCategories = $this->searchService->search($query, $request);



        return   RequestTypeCategoryResource::collection($RequestCategories);
    }


}
