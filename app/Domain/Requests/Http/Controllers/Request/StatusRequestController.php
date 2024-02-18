<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\RequestShow\RequestTransactionResource;
use App\Domain\Requests\Models\Request as ModelsRequest;
use App\Domain\Requests\Models\RequestSteps;
use App\Domain\Requests\Models\RequestTransaction;
use App\Domain\Requests\Services\RequestRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusRequestController extends Controller
{
    public function __construct(
        private readonly RequestRegisterService $requestRegisterService
    ) {
    }

    #[
        Post(
            path: "/api/v1/change/status/request",
            summary: "change status of request   ",
            security: [["sanctum" => []]],
            requestBody: new RequestBody(
                description: "change status of request",
                required: true,
                content: new JsonContent(
                    required: [  "request_id"],
                    properties: [
                        new Property(
                            property: "notes",
                            type: "string",
                            example: "Doe...."
                        ),


                        new Property(
                            property: "request_id",
                            type: "integer",
                            example: 1
                        ),

                        new Property(
                            property: "step_action_id",
                            type: "integer",
                            example: 1
                        ),


                    ]
                )
            ),
            tags: ["Request"],
            responses: [
                new \OpenApi\Attributes\Response(
                    response: 200,
                    description: "Request registered successfully",
                    content: new JsonContent(
                        ref: "#/components/schemas/RequestResource"
                    )
                ),
                new \OpenApi\Attributes\Response(
                    response: 400,
                    description: "Bad Request"
                ),
                new \OpenApi\Attributes\Response(
                    response: 422,
                    description: "Validation failed"
                ),
            ]
        )
    ]
    public function __invoke(Request $request): JsonResponse
    {
        $profile = auth()->user()?->currentProfile();

        $requestId = $request->get('request_id');

        /**  Approved = 1 // Reject = 2  //  Return = 3  */
        $requestStatusId = $request->get('step_action_id');
        $note = $request->get('notes');


        $itemRequest = ModelsRequest::where('id', $requestId)->first();
        $itemRequestSteps = RequestSteps::where('request_id', $requestId) ->where('status', 0)->first();


        $entity = RequestTransaction::create([
             'request_id' =>  $requestId ,
             'request_steps_id' => $itemRequestSteps->id  ,
             'profile_id' => $profile ->id ,
             'step_action_id' =>  $requestStatusId  ,
             'note' =>  $note ,
             ]) ;


        /** if step_action_id == 1  Approved  */
        if($requestStatusId == 1) {
            $itemRequestSteps -> status = 1 ;
            $itemRequestSteps -> save() ;

            $item = RequestSteps::where('request_id', $requestId) ->where('status', 0)->first();

            if(empty($item)) {
                $itemRequest -> request_status_id = 4 ;
                $itemRequest -> save() ;
            }

        }
        /** if step_action_id == 2 Reject    */
        elseif($requestStatusId == 2) {
            $itemRequestSteps -> status = 1 ;
            $itemRequestSteps -> save() ;

            $itemRequest -> request_status_id = 2 ;
            $itemRequest -> save() ;

        }

        /** if step_action_id == 3 Return    */
        elseif($requestStatusId == 3) {
            $itemRequestSteps -> status = 1 ;
            $itemRequestSteps -> save() ;

            $itemRequest -> request_status_id = 1 ;
            $itemRequest -> save() ;
            $item = RequestSteps::where('request_id', $requestId)->update(['status' => 0]);
        }


        return response()->json(new RequestTransactionResource($entity), Response::HTTP_CREATED);
    }
}
