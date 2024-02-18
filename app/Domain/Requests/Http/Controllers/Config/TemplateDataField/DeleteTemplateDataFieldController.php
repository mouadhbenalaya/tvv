<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\TemplateDataField;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\TemplateDataField;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteTemplateDataFieldController extends Controller
{
    #[Delete(
        path: '/api/v1/template-data-field/{templateDataField}',
        summary: 'Delete templateDataField',
        security: [['sanctum' => []]],
        tags: [
            'Template Data Field',
        ],
        parameters: [
            new Parameter(
                name: 'templateDataField',
                description: 'templateDataField id',
                in: 'path',
                required: true,
                example: 1,
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 204,
                description: 'Deleted',
                content: new JsonContent(
                    properties: [
                        new Property(
                            property: 'message',
                            type: 'string',
                            example: 'templateDataField deleted.',
                        ),
                    ],
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
    public function __invoke(TemplateDataField $templateDataField): JsonResponse
    {
        // $this->authorize('delete', $requestType);

        $templateDataField->delete();

        return response()->json(['message' => 'Template Data Field deleted.']);
    }
}
