<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\FieldType;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\FieldType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteFieldTypeController extends Controller
{
    #[Delete(
        path: '/api/v1/field-type/{fieldType}',
        summary: 'Delete field Type',
        security: [['sanctum' => []]],
        tags: [
            'Field Type',
        ],
        parameters: [
            new Parameter(
                name: 'fieldType',
                description: 'field type id',
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
                            example: 'Field type deleted.',
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
    public function __invoke(FieldType $fieldType): JsonResponse
    {
        // $this->authorize('delete', $requestType);

        $fieldType->delete();

        return response()->json(['message' => 'Field type deleted.']);
    }
}
