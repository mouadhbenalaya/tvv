<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestTypes\GetRequestResource;
use App\Domain\Requests\Http\Resources\Request\StepActionResource;
use App\Domain\Requests\Models\Request as ModelsRequest;
use App\Domain\Requests\Models\RequestSteps;
use App\Domain\Requests\Models\StepAction;
use App\Domain\Requests\Services\RequestListInBoxService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Schema;

use Symfony\Component\HttpFoundation\Response;

use function response;

class GetInfoRequestController extends Controller
{
    /**
    * @param RequestListInBoxService $requestListInBoxService
    */
    public function __construct(
        private readonly RequestListInBoxService $requestListInBoxService,
    ) {
    }
    #[Get(
        path: '/api/v1/get-info-request/{idRequest}',
        summary: 'Get single request Type data',
        security: [['sanctum' => []]],
        tags: [
            'Request',
        ],
        parameters: [

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
            new Parameter(
                name: 'idRequest',
                description: 'Get request by id',
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
                    ref: '#/components/schemas/GetRequestResource',
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
    public function __invoke($request): JsonResponse
    {


        $entity = ModelsRequest::where('id', $request)->first();

        return response()->json(new GetRequestResource($entity), Response::HTTP_OK);

    }
}
