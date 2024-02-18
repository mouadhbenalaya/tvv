<?php

namespace App\Domain\Requests\Http\Controllers\TemplateStep;

use App\Domain\Requests\Http\Resources\RequestTypes\TemplateStepResource;
use App\Domain\Requests\Services\TemplateStepService;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\TemplateStepRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class TemplateStepCreateController extends Controller
{
    public function __construct(
        private readonly TemplateStepService $templateStepService,
    ) {
    }

    #[Post(
        path:  '/api/v1/request/template-step/create',
        summary:'create of template step ',
        security: [['sanctum' => []]],
        requestBody: new RequestBody(
            description: 'Template Step ',
            required: true,
            content: new JsonContent(
                required: [   'role_id',  'request_type_id' , 'step_sequence' , 'step_title' , 'can_reject' , 'can_return'  ],
                properties: [

                    new Property(
                        property: 'can_return',
                        type: 'boolean',
                        example: 1,
                    ),
                    new Property(
                        property: 'can_reject',
                        type: 'boolean',
                        example: 1,
                    ) ,
                    new Property(
                        property: 'step_title_en',
                        type: 'string',
                        example: "Create order",
                    ),
                    new Property(
                        property: 'step_title_ar',
                        type: 'string',
                        example: "إنشاء الطلب ",
                    ),
                    new Property(
                        property: 'step_sequence',
                        type: 'integer',
                        example: 1,
                    ),


                    new Property(
                        property: 'request_type_id',
                        type: 'integer',
                        example: 1,
                    ),

                    new Property(
                        property: 'request_permission_id',
                        type: 'integer',
                        example: 1,
                    ),

                ],
            ),
        ),
        tags: [
            'Template Step',
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'field from  registered successfully',
                content: new JsonContent(
                    ref: '#/components/schemas/TemplateStepResource',
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

    public function __invoke(TemplateStepRequest $request): JsonResponse
    {
        $requestData = $request->all($request->getFields());
        $templateStep = $this->templateStepService->createTemplateStep($requestData);

        return response()->json(new TemplateStepResource($templateStep), Response::HTTP_CREATED);
    }
}
