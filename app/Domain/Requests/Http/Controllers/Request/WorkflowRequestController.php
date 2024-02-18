<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestShow\WorkflowRequestResource;

use App\Domain\Requests\Models\RequestTransaction;
use Illuminate\Http\JsonResponse;
use App\Common\Services\SearchService;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Parameter;
use Symfony\Component\HttpFoundation\Response;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Requests\Http\Resources\Request\WorkflowRequestStepsResource;
use App\Domain\Requests\Http\Resources\Request\WorkflowRequestTransactionResource;
use App\Domain\Requests\Http\Resources\Request\StepActionResource;
use App\Domain\Requests\Models\StepAction;
use App\Domain\Requests\Models\RequestStatus;
use App\Domain\Requests\Models\RequestSteps;
use Illuminate\Http\Resources\Json\ResourceCollection;

use function response;

class WorkflowRequestController extends Controller
{
    /**
      * @param SearchService $searchService
      */
    public function __construct(
        private readonly SearchService $searchService
    ) {
    }
    #[Get(
        path: '/api/v1/request-workflow/{idRequest}',
        summary: 'Get workflow request by id ',
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
                    ref: '#/components/schemas/RequestTransactionResource',
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

    public function __invoke($idRequest): JsonResponse
    {
        $res = [] ;
        $results = [] ;
        $requestResource = [];
        $requestTransaction = RequestTransaction::query();

        $requestTransaction = $requestTransaction->where('request_id', $idRequest) ->get();

        if(!empty($requestTransaction)) {
            $results =   WorkflowRequestTransactionResource::collection($requestTransaction); 
        }


        if((!empty($requestTransaction) and $requestTransaction->last()->step_action_id != 2) or empty($requestTransaction)) {

            $requestSteps = RequestSteps::where('request_id', $idRequest)-> where('status', 0) ;
            $requestResource =  WorkflowRequestStepsResource::collection($requestSteps->get());
        }

        $res =   array_merge(json_decode(json_encode($results)), json_decode(json_encode($requestResource)));


        $result['data'] =  $res ;
        $result['codeColor'] = json_decode(json_encode(StepActionResource::collection(StepAction::get()))) ;

        return response()->json($result, Response::HTTP_CREATED);


    }
}
