<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\FormRequest;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataResource;
use App\Domain\Requests\Models\TemplateData;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveFormRequestController extends Controller
{
    #[Get(
        path: '/api/v1/template-datas/{templateData}',
        summary: 'Get single request Type data',
        security: [['sanctum' => []]],
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
                response: 200,
                description: 'Success',
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
        ],
    )]
    public function __invoke(TemplateData $templateData): JsonResponse
    {
        return response()->json(new TemplateDataResource($templateData), Response::HTTP_OK);
    }
}
