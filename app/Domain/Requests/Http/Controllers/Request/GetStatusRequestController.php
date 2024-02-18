<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Resources\Request\StepActionResource;
use App\Domain\Requests\Models\RequestSteps;
use App\Domain\Requests\Models\StepAction;
use App\Domain\Requests\Services\RequestRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetStatusRequestController extends Controller
{
    public function __construct(
        private readonly RequestRegisterService $requestRegisterService
    ) {
    }

    #[
        Post(
            path: "/api/v1/get/status/request",
            summary: "change status of request   ",
            security: [["sanctum" => []]],
            requestBody: new RequestBody(
                description: "change status of request",
                required: true,
                content: new JsonContent(
                    required: ["request_id"],
                    properties: [
                        new Property(
                            property: "request_id",
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
        $requestId = $request->get("request_id");
        $stepAction = [];
        $arrayId = [];
        $itemRequestSteps = RequestSteps::where("request_id", $requestId)
            ->where("status", 0)
            ->first();

        if (!empty($itemRequestSteps)) {
            /**  Approved = 1   */
            $arrayId = [1];
            /**   Return = 3  */
            if ($itemRequestSteps->can_return == 1) {
                $item = [3];
                $arrayId = array_merge($arrayId, $item);
            }

            /**   can_reject = 3  */
            if ($itemRequestSteps->can_reject == 1) {
                $item = [2];
                $arrayId = array_merge($arrayId, $item);
            }

            $stepAction = StepAction::whereIn("id", $arrayId)->get();
        }

        return response()->json(
            StepActionResource::collection($stepAction),
            Response::HTTP_CREATED
        );
    }
}
