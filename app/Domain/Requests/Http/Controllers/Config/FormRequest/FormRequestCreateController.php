<?php

namespace App\Domain\Requests\Http\Controllers\Config\FormRequest;

use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\TemplateDataRequest;
use App\Domain\Requests\Services\TemplateDataRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class FormRequestCreateController extends Controller
{
    public function __construct(
        private readonly TemplateDataRegisterService $templateDataRegisterService,
    ) {
    }

    #[Post(
        path:  '/api/v1/template-datas/create',
        summary:'create of request Type ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Register template from',
            required: true,
            content: new JsonContent(
                required: [
                    'enabled',
                    'title',
                    'request_type_id'
                ],
                properties: [

                    new Property(
                        property: 'enabled',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'title',
                        type: 'string',
                        example: 'Doe',
                    ),

                    new Property(
                        property: 'description',
                        type: 'string',
                        example: 'Doe ',
                    ),
                    new Property(
                        property: 'type_data',
                        type: 'string',
                        example: 'Table|form',
                    ),
                    new Property(
                        property: 'template_data_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'request_type_id',
                        type: 'integer',
                        example: 1,
                    ),
                    new Property(
                        property: 'field_name',
                        type: [],
                        example: ['FullNAme',"Age"],
                    ),
                    new Property(
                        property: 'label',
                        type: [],
                        example: ['Full NAme',"Age"],
                    ),
                    new Property(
                        property: 'name_table_relationship',
                        type: [],
                        example: ['Country',"WfLookups"],
                    ),
                    new Property(
                        property: 'type_data_table_relationship',
                        type: [],
                        example: ['hobbies',"gender"],
                    ),
                    new Property(
                        property: 'template_data_field',
                        type: [],
                        example: [1,2],
                    ),

                    new Property(
                        property: 'required_data_field',
                        type: [],
                        example: [1,0,1],
                    ),

                    new Property(
                        property: 'readonly_data_field',
                        type: [],
                        example: [1,0,1],
                    ),

                ],
            ),
        ),
        tags: [
            'Template data',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Template from  registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/TemplateDataResource',
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

    public function __invoke(TemplateDataRequest $request): JsonResponse
    {
        $requestData = $request->all($request->getFields());
        $listField = $request->only('template_data_field')  ;
        $listLabel = $request->only('label')  ;
        $listFieldName = $request->only('field_name')  ;
        $listTableRelationship = $request->only('name_table_relationship')  ;
        $listTypeDataRelationship = $request->only('type_data_table_relationship')  ;
        $listReadonlyDataField = $request->only('readonly_data_field')  ;
        $listRequiredDataField = $request->only('required_data_field')  ;

        $requestType = $this->templateDataRegisterService->createTemplateFrom($requestData);

        if(!empty($listField['template_data_field'])) {
            $this->templateDataRegisterService->createTemplateDataField($listField['template_data_field'], $listLabel ['label'], $listFieldName ['field_name'], $listTableRelationship ['name_table_relationship'], $listTypeDataRelationship ['type_data_table_relationship'], $listRequiredDataField ['required_data_field'], $listReadonlyDataField ['readonly_data_field'], $requestType->id);
        }


        return response()->json(new TemplateDataResource($requestType), Response::HTTP_CREATED);
    }
}
