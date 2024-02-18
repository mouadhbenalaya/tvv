<?php

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Domain\Requests\Http\Resources\RequestTypes\DataSelectResource;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\FieldType;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\TemplateData;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use App\Common\Models\City ;
use App\Common\Models\Region ;

use Symfony\Component\HttpFoundation\Response;

class DataSelectController extends Controller
{
    #[Get(
        path: '/api/v1/get-data-select/{nameTable}',
        summary: 'Get data select',
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
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/DataSelectResource',
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
    public function __invoke($nameTable): ResourceCollection
    {


        $list = [];

        switch ($nameTable) {
            case 'FieldType':
                $list = FieldType::select('name AS title', 'id')->get();
                break;
            case 'RequestType':
                $list = RequestType::select('title', 'id')->get();
                break;
            case 'TemplateData':
                $list = TemplateData::select('title', 'id')->get();
                break;

            case 'City':
                $list = City::select('name_ar as title_ar ', 'name as title_en ', 'id') ->get();
                break;
            case 'Region':
                $list = Region::select('name_ar as title_ar ', 'name as title_en ', 'id') ->get();
                break;
        }
        return DataSelectResource::collection($list);

    }


}
