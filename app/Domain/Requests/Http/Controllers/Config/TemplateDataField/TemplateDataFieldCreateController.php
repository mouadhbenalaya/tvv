<?php

namespace App\Domain\Requests\Http\Controllers\Config\TemplateDataField;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataFieldResource;
use App\Domain\Requests\Http\Requests\TemplateDataFieldRequest;
use App\Domain\Requests\Services\TemplateDataFieldRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class TemplateDataFieldCreateController extends Controller
{
    public function __construct(
        private readonly TemplateDataFieldRegisterService $templateDataFieldRegisterService,
    ) {
    }

    #[Post(
        path:  '/api/v1/template-data-field/create',
        summary:'create of field Type ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'field field ',
            required: true,
            content: new JsonContent(
                required: [ 'field_type_id',  'template_data_id'  ],
                properties: [

                    new Property(
                        property: 'field_type_id',
                        type: 'integer',
                        example: 1,
                    ),

                    new Property(
                        property: 'template_data_id',
                        type: 'integer',
                        example: 1,
                    ),

                    new Property(
                        property: 'required',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'readonly',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'enabled',
                        type: 'boolean',
                        example: 1,
                    ),

                    new Property(
                        property: 'template_data_field_id',
                        type: 'integer',
                        example: 1,
                    ),



                    new Property(
                        property: 'label',
                        type: 'string',
                        example: 'Full Name ',
                    ),

                    new Property(
                        property: 'label_ar',
                        type: 'string',
                        example: 'Full Name ',
                    ),

                    new Property(
                        property: 'field_name',
                        type: 'string',
                        example: 'FullName',
                    ),
                    new Property(
                        property: 'name_table_relationship',
                        type: 'string',
                        example: 'name_table',
                    ),
                    new Property(
                        property: 'type_data_table_relationship',
                        type: 'string',
                        example: 'gender',
                    ),



                ],
            ),
        ),
        tags: [
            'Template Data Field',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'field from  registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/TemplateDataFieldResource',
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

    public function __invoke(TemplateDataFieldRequest $request): JsonResponse
    {
        $requestData = $request->all($request->getFields());
        $templateDataField = $this->templateDataFieldRegisterService->createTemplateDataField($requestData);

        return response()->json(new TemplateDataFieldResource($templateDataField), Response::HTTP_CREATED);
    }
}
