<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Config\RequestType;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\RequestType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Property;
use Symfony\Component\HttpFoundation\Response;

class DeleteRequestTypController extends Controller
{
    #[Delete(
        path: '/api/v1/request-types/{requestType}',
        summary: 'Delete request Types',
        security: [['sanctum' => []]],
        tags: [
            'Request Type Categories',
        ],
        parameters: [
            new Parameter(
                name: 'requestType',
                description: 'requestType id',
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
                            example: 'Request Type deleted.',
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
    public function __invoke(RequestType $requestType): JsonResponse
    {
        // $this->authorize('delete', $requestType);
        $requestType->delete();


        return response()->json(['message' => 'form request deleted.']);
    }
}
