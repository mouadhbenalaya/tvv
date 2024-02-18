<?php

namespace App\Domain\Requests\Http\Controllers\Config\FieldType;

use App\Domain\Requests\Http\Resources\FormRequest\FieldTypeResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\FieldTypeRequest;
use App\Domain\Requests\Services\FieldTypeRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class FieldTypeCreateController extends Controller
{
    public function __construct(
        private readonly FieldTypeRegisterService $fieldTypeRegisterService,
    ) {
    }

    #[Post(
        path:  '/api/v1/field-type/create',
        summary:'create of field Type ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'field field ',
            required: true,
            content: new JsonContent(
                required: [ 'enabled',  'name' , 'class', 'type_field','name_field' ],
                properties: [

                    new Property(
                        property: 'enabled',
                        type: 'boolean',
                        example: 1,
                    ),
                     new Property(
                         property: 'name',
                         type: 'string',
                         example: 'fullName',
                     ),

                    new Property(
                        property: 'class',
                        type: 'string',
                        example: 'col-md-12 ',
                    ),
                    new Property(
                        property: 'type_field',
                        type: 'string',
                        example: 'input',
                    ),
                    new Property(
                        property: 'name_field',
                        type: 'string',
                        example: 'input|select|...',
                    ),
                    new Property(
                        property: 'name_table_relationship',
                        type: 'string',
                        example: 'employee|jobs|...',
                    ),




                ],
            ),
        ),
        tags: [
            'Field Type',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'field from  registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/FieldTypeResource',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]

    public function __invoke(FieldTypeRequest $request): JsonResponse
    {
        $requestData = $request->all($request->getFields());
        $fieldType = $this->fieldTypeRegisterService->createFieldType($requestData);

        return response()->json(new FieldTypeResource($fieldType), Response::HTTP_CREATED);
    }
}
