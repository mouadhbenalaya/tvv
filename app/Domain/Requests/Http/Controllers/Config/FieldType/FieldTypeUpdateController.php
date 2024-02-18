<?php

namespace App\Domain\Requests\Http\Controllers\Config\FieldType;

use App\Domain\Requests\Http\Resources\FormRequest\FieldTypeResource;
use App\Domain\Requests\Http\Requests\FieldTypeRequest;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\FieldType;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;

class FieldTypeUpdateController extends Controller
{
    #[Put(
        path: '/api/v1/field-type/{fieldType}',
        summary:'Update existing  Field',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Update existing Field',
            required: true,
            content: new JsonContent(
                required: [ 'enabled',  'name' , 'class', 'type_field' ],
                properties: [

                    new Property(
                        property: 'enabled',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'name_field',
                        type: 'string',
                        example: 'input|select|...',
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
        parameters: [
            new Parameter(
                name: 'fieldType',
                description: 'fieldType id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 201,
                description: 'Template Form created successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/FieldTypeResource',
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
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]
    public function __invoke(FieldTypeRequest $request, FieldType $fieldType): JsonResponse
    {

        $fieldType->update($request->all());

        return response()->json(new FieldTypeResource($fieldType), Response::HTTP_OK);
    }
}
