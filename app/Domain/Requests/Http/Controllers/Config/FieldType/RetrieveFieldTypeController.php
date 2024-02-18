<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\FieldType;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\FormRequest\FieldTypeResource;
use App\Domain\Requests\Models\FieldType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Examples;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

use Symfony\Component\HttpFoundation\Response;

use function response;

class RetrieveFieldTypeController extends Controller
{
    #[Get(
        path: '/api/v1/field-type/{fieldType}',
        summary: 'Get single field data',
        security: [['sanctum' => []]],
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
            new Parameter(
                name: 'locale',
                description: 'Language locale',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    enum: [
                        'en',
                        'ar',
                    ],
                ),
            ),
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
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
        ],
    )]
    public function __invoke(FieldType $fieldType): JsonResponse
    {
        return response()->json(new FieldTypeResource($fieldType), Response::HTTP_OK);
    }
}
