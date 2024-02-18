<?php

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Domain\Requests\Http\Resources\RequestTypes\ApiGetDataSelectResource;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\FieldType;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\WfLookups;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use App\Common\Models\City ;
use App\Common\Models\Region ;
use App\Common\Models\Country ;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes\Schema;

class GetDataSelectByIdController extends Controller
{
    #[Get(
        path: '/api/v1/get-data-by-id/{nameTable}/{idItem}/{champRelationship}',
        summary: 'Get data select by id',
        security: [['sanctum' => []]],
        tags: [
            'Generate from',
        ],
        parameters: [

            new Parameter(
                name: 'nameTable',
                description: 'nameTable  ',
                in: 'path',
                required: true,
                example: "employee",
            ),
            new Parameter(
                name: 'champRelationship',
                description: 'champRelationship  ',
                in: 'path',
                required: false,
                example: "city_id",
            ),
            new Parameter(
                name: 'idItem',
                description: 'idItem  ',
                in: 'path',
                required: false,
                example: 3,
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
                    ref: '#/components/schemas/ApiGetDataSelectResource',
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
    public function __invoke($nameTable, $idItem, $champRelationship): ResourceCollection
    {

        switch ($nameTable) {
            case 'FieldType':
                $list = FieldType::select('name AS title', 'id')->get();
                break;
            case 'Country':
                $list = Country::select('name_ar as title_ar', 'name as title_en', 'id')->get();
                break;
            case 'City':
                if(!empty($idItem))
                     $list = City::select('name_ar as title_ar', 'name as title_en', 'id')->where('region_id', $idItem)->get();
                else
                     $list = City::select('name_ar as title_ar', 'name as title_en', 'id')->get();
                break;
            case 'Region':
                if(!empty($idItem))
                      $list = Region::select('name_ar as title_ar', 'name as title_en', 'id')->where('countrie_id', $idItem)->get();
                else
                     $list = Region::select('name_ar as title_ar', 'name as title_en', 'id')->get();

                break;
            default:
                $list = WfLookups::where('type_data', $champRelationship)->get();
                break;

        }

        return ApiGetDataSelectResource::collection($list);

    }


}
