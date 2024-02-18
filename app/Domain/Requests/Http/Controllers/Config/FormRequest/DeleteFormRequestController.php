<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\FormRequest;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\TemplateData;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteFormRequestController extends Controller
{
    #[Delete(
        path: '/api/v1/template-datas/{templateData}',
        summary: 'Delete Template data',
        security: [['sanctum' => []]],
        tags: [
            'Template data',
        ],
        parameters: [
            new Parameter(
                name: 'templateData',
                description: 'Template data id',
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
                            example: 'form request deleted.',
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
    public function __invoke(TemplateData $templateData): JsonResponse
    {
        // $this->authorize('delete', $requestType);

        $templateData->delete();

        return response()->json(['message' => 'form request deleted.']);
    }
}
