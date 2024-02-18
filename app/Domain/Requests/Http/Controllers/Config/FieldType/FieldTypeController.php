<?php

namespace App\Domain\Requests\Http\Controllers\Config\FieldType;

use App\Domain\Requests\Http\Resources\FormRequest\FieldTypeResource;

use App\Common\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Services\SearchService;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Requests\Models\FieldType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;

class FieldTypeController extends Controller
{
    /**
      * @param SearchService $searchService
      */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/field-type',
        summary: 'Get list of Form Request',
        security: [['sanctum' => []]],
        tags: [
            'Field Type',
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
                        ref: '#/components/schemas/FieldTypeResource',
                    ),
                ),
            ),
            new Response(
                response: 400,
                description: 'Bad Request',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request): ResourceCollection
    {

        $fieldTypes = $this->searchService->search(FieldType::query(), $request);

        return FieldTypeResource::collection($fieldTypes);


    }


}
