<?php

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Domain\Requests\Http\Resources\RequestShow\RequestResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Http\Requests\RequestRequest;
use App\Domain\Requests\Services\RequestRegisterService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\TemplateDataField;
use App\Domain\Requests\Models\RequestDataField;
use App\Domain\Requests\Models\RequestData;
use App\Domain\Requests\Models\RequestStatus;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class RequestCreateController extends Controller
{
    public function __construct(
        private readonly RequestRegisterService $requestRegisterService
    ) {
    }

    #[
        Post(
            path: "/api/v1/request/create",
            summary: "create of request   ",
            security: [["sanctum" => []]],
            requestBody: new RequestBody(
                description: "Register request",
                required: true,
                content: new JsonContent(
                    required: ["enabled", "title", "request_type_id"],
                    properties: [
                        new Property(
                            property: "notes",
                            type: "string",
                            example: "Doe...."
                        ),


                        new Property(
                            property: "profile_id",
                            type: "integer",
                            example: 1
                        ),

                        new Property(
                            property: "request_type_id",
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
    public function __invoke(RequestRequest $request): JsonResponse
    {

        /** Create Request */
        $ListData = $request->only([
            "request_type_id",
            "profile_id",
            "notes",
        ]);




        $requestItem = $this->requestRegisterService->createRequest($ListData);

        /** Call Function get  data-dependent   */
         $this->requestRegisterService->getInfoRequest($requestItem);
        
        $this->requestRegisterService->createRequestSteps($requestItem);
        /** End Create Request */

        /** Create RequestData */

        $templateData = TemplateData::where("request_type_id", $ListData["request_type_id"])->get();

        $requestData = [];
        $data = [];
        foreach ($templateData as $key => $item) {
            $value = RequestData::where("template_data_id", $item->id)
                ->where("request_id", $requestItem->id)
                ->first();
            $nameValue = "titleBlock" . $item->id;

            if (empty($value)) {
                $requestData["description"] = $item->description;
                $requestData["title"] = $item->title;
                $requestData["description_ar"] = $item->description_ar;
                $requestData["title_ar"] = $item->title_ar;
                $requestData["type_data"] = $item->type_data;

                if (!empty($item->template_data_id)) {
                    $entity = RequestData::where(
                        "template_data_id",
                        $item->template_data_id
                    )->first();
                    $requestData["request_data_id"] = $entity->id;
                }

                $requestData["request_id"] = $requestItem->id;
                $requestData["template_data_id"] = $item->id;

                $requestentity = $this->requestRegisterService->createRequestData(
                    $requestData
                );

                /** End Create RequestData */

                /** Create RequestDataField */
                $templateDataField = TemplateDataField::where(
                    "template_data_id",
                    $item->id
                )->get();

                foreach ($templateDataField as $entity) {
                    $field_value = null;

                    if (!empty($request["data"][$nameValue][$entity->field_name])) {
                        if ($entity->fieldType->type_field == "array") {

                            $field_value = implode(
                                ",",
                                $request["data"][$nameValue][
                                    $entity->field_name
                                ]
                            );
                        } elseif ($entity->fieldType->name_field == "radio") {
                            $field_value =
                                $request["data"][$nameValue][
                                    $entity->field_name
                                ];
                        } else {
                            $field_value =
                                $request["data"][$nameValue][
                                    $entity->field_name
                                ];
                        }
                    } else {
                        $field_value = null;
                    }

                    $data["field_value"] = $field_value;
                    $data["template_data_field_id"] =  $entity->id;
                    $data["label"] = $entity->label;
                    $data["label_ar"] = $entity->label_ar;
                    $data["field_name"] = $entity->field_name;
                    $data["field_type_id"] = $entity->field_type_id;
                    if (!empty($requestentity)) {
                        $data["request_data_id"] = $requestentity->id;
                    }

                    $data["is_overwritten"] = $entity->enabled;

                    if (!empty($entity->template_data_field_id)) {
                        $templateDataFieldById = TemplateDataField::where(
                            "id",
                            $entity->template_data_field_id
                        )->first();
                        $itemRequestDataField = RequestDataField::where(
                            "field_type_id",
                            $templateDataFieldById->field_type_id
                        )
                            ->where("request_data_id", $requestentity->id)
                            ->first();

                        if (!empty($itemRequestDataField)) {
                            $data["request_data_field_id"] =  $itemRequestDataField->id;
                        }

                    } else {
                        $data["request_data_field_id"] = null;
                    }

                    if (!empty($data)) {

                        RequestDataField::insert($data);
                    }

                    /** End Create RequestDataField */
                }
            }
        }

        return response()->json(
            new RequestResource($requestItem),
            Response::HTTP_CREATED
        );
    }
}
