<?php

namespace App\Domain\Requests\Http\Controllers\Config\FormRequest;

use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataResource;
use App\Domain\Requests\Http\Requests\TemplateDataRequest;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\TemplateData;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;

class FormRequestUpdateController extends Controller
{
    #[Put(
        path: '/api/v1/template-datas/{templateData}',
        summary:'Update existing   Template Form ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Update existing  Template Form',
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
                        example: 'Table',
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

                ],
            ),
        ),
        tags: [
            'Template data',
        ],
        parameters: [
            new Parameter(
                name: 'templateData',
                description: 'templateData id',
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
                    ref: '#/components/schemas/TemplateDataResource',
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
    public function __invoke(TemplateDataRequest $request, TemplateData $templateData): JsonResponse
    {

        $templateData->update($request->all());

        return response()->json(new TemplateDataResource($templateData), Response::HTTP_OK);
    }
}
