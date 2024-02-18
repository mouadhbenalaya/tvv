<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Requests\Http\Controllers\Request\GetDataSelectByIdController;
use App\Domain\Requests\Http\Resources\Request\StepActionResource;
use App\Domain\Requests\Http\Resources\RequestShow\RequestStatusResource;
use App\Domain\Requests\Models\RequestSteps;
use App\Domain\Requests\Models\StepAction;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use App\Domain\Requests\Services\GetDataSelectService;
use App\Domain\Requests\Services\RequestListInBoxService;
use App\Domain\Users\Http\Resources\User\ProfileResource;

/**
 * Class GetRequestResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[
    Schema(
        title: "GetRequest  resource",
        description: "GetRequest  resource",
        properties: [new Property(property: "release_date", type: "date")],
        type: "object"
    )
]
class GetRequestResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $result = [];
        $resultUiSchema = [];
        $resultFormData = [];
        foreach ($this->requestDatas as $requestData) {
            $formSchema = [];
            $properties = [];
            $uiSchema = [];
            $formData = [];
            $requiredField = [];
            $enum = [];
            $enumSelect = [];

            $entities = $requestData->requestDataFields;
            $entities = $entities->sortByDesc("field_name");
            $title = "titleBlock" . $requestData->id;

            $oldFieldName = null;
            foreach ($entities as $key => $value) {
                if ($oldFieldName == null) {
                    $oldFieldName = $value->field_name;
                }

                if ($oldFieldName != $value->field_name) {
                    $enum = [];
                    $enumSelect = [];
                    $oneOf = [];
                    $oldFieldName = $value->field_name;
                }

                /** Structure json for type radio */
                if ($value->fieldType->name_field == "radio") {
                    if (
                        !empty(
                            $value->templateDataField->name_table_relationship
                        )
                    ) {
                        $getDataSelectServices = new GetDataSelectService();

                        $entities = $getDataSelectServices->getDatas(
                            $value->templateDataField->name_table_relationship,
                            null,
                            $value->templateDataField
                                ->type_data_table_relationship
                        );

                        $oneOf = [];

                        if (!empty($entities)) {
                            foreach ($entities as $index => $item) {
                                $oneOf[$index] = [
                                    "const" => $item->id,
                                    "title" =>
                                        \App::getLocale() == "ar"
                                            ? $item->title_ar
                                            : $item->title_en,
                                ];
                            }

                            $properties[$value->field_name] = [
                                "type" => $value->fieldType->type_field,
                                "title" =>
                                    \App::getLocale() == "ar"
                                        ? $value->label_ar
                                        : $value->label,
                                "name_table_relationship" => !empty(
                                    $value->templateDataField
                                )
                                    ? $value->templateDataField
                                        ->name_table_relationship
                                    : null,
                                "oneOf" => $oneOf,
                            ];
                        }
                    }
                }
                /** Structure json for type Single checkbox */ elseif (
                    $value->fieldType->name == "Single checkboxes"
                ) {
                    $enum[0] = [
                        "const" => 1,
                        "title" =>
                            \App::getLocale() == "ar"
                                ? $value->label_ar
                                : $value->label,
                    ];
                    $properties[$value->field_name] = [
                        //   'id' => $value->fieldType->id,
                        "type" => $value->fieldType->type_field,
                        "title" => " ",
                        "name_table_relationship" => !empty(
                            $value->templateDataField
                        )
                            ? $value->templateDataField->name_table_relationship
                            : null,
                        "items" => [
                            "type" => "number",
                            "anyOf" => $enum,
                        ],
                        "uniqueItems" => true,
                    ];
                }
                /** Structure json for type checkbox */ elseif (
                    $value->fieldType->name_field == "checkboxes"
                ) {
                    $getDataSelectServices = new GetDataSelectService();

                    $entities = $getDataSelectServices->getDatas(
                        $value->templateDataField->name_table_relationship,
                        null,
                        $value->templateDataField->type_data_table_relationship
                    );

                    if (!empty($entities)) {
                        foreach ($entities as $index => $item) {
                            $enum[$index] = [
                                "const" => $item->id,
                                "title" =>
                                    \App::getLocale() == "ar"
                                        ? $item->title_ar
                                        : $item->title_en,
                            ];
                        }

                        $properties[$value->field_name] = [
                            //   'id' => $value->fieldType->id,
                            "type" => $value->fieldType->type_field,
                            "title" =>
                                \App::getLocale() == "ar"
                                    ? $value->label_ar
                                    : $value->label,
                            "name_table_relationship" => !empty(
                                $value->templateDataField
                            )
                                ? $value->templateDataField
                                    ->name_table_relationship
                                : null,
                            "items" => [
                                "type" => "number",
                                "anyOf" => $enum,
                            ],
                            "uniqueItems" => true,
                        ];
                    }
                }
                /** Structure json for type select */ elseif (
                    $value->fieldType->name_field == "select"
                ) {
                    $enumSelect = [];

                    if (
                        !empty(
                            $value->templateDataField->name_table_relationship
                        )
                    ) {
                        // get data radio
                        $getDataSelectServices = new GetDataSelectService();

                        $entities = $getDataSelectServices->getDatas(
                            $value->templateDataField->name_table_relationship,
                            null,
                            $value->templateDataField
                                ->type_data_table_relationship
                        );

                        if (!empty($entities)) {
                            $valueSelect = null;
                            foreach ($entities as $index => $item) {
                                $enumSelect[$index] = [
                                    "const" => $item->id,
                                    "title" =>
                                        \App::getLocale() == "ar"
                                            ? $item->title_ar
                                            : $item->title_en,
                                ];
                                if (empty($valueSelect)) {
                                    $valueSelect = $item->id;
                                }
                            }

                            $properties[$value->field_name] = [
                                //   'id' => $value->fieldType->id,
                                "type" => $value->fieldType->type_field,
                                "title" =>
                                    \App::getLocale() == "ar"
                                        ? $value->label_ar
                                        : $value->label,
                                "name_table_relationship" => !empty(
                                    $value->templateDataField
                                )
                                    ? $value->templateDataField
                                        ->name_table_relationship
                                    : null,
                                "oneOf" => $enumSelect, // ['كرة القدم' , 'كرة اليد'  , 'موسيقى']
                                "default" => $valueSelect,
                            ];
                        }
                    }
                }
                /** Structure json for other type  */ elseif (
                    $value->fieldType->name_field == "date"
                ) {
                    $properties[$value->field_name] = [
                        //     'id' => $value->fieldType->id,
                        "type" => $value->fieldType->type_field,
                        "format" => "date",
                        "title" =>
                            \App::getLocale() == "ar"
                                ? $value->label_ar
                                : $value->label,
                        "name_table_relationship" => !empty(
                            $value->templateDataField
                        )
                            ? $value->templateDataField->name_table_relationship
                            : null,
                    ];
                } /** Structure json for other type  */ else {
                    $properties[$value->field_name] = [
                        //     'id' => $value->fieldType->id,
                        "type" => $value->fieldType->type_field,
                        "title" =>
                            \App::getLocale() == "ar"
                                ? $value->label_ar
                                : $value->label,
                        "name_table_relationship" => !empty(
                            $value->templateDataField
                        )
                            ? $value->templateDataField->name_table_relationship
                            : null,
                    ];
                }

                $uiSchema[$value->field_name] = [
                    "ui:widget" => $value->fieldType->name_field,
                    "ui:readonly" =>
                        $value->templateDataField->readonly == 1 ? true : false,
                ];

                if (!empty($value->field_value)) {
                    if (
                        $value->fieldType->name_field == "checkboxes" or
                        $value->fieldType->name_field == "radio"
                    ) {
                        $integerIDs = array_map(
                            "intval",
                            explode(",", $value->field_value)
                        );
                        $formData[$value->field_name] = $integerIDs;
                    } else {
                        $formData[$value->field_name] = $value->field_value;
                    }

                    $resultFormData[$title] = $formData;
                }

                if ($value->templateDataField->required == 1) {
                    array_push($requiredField, $value->field_name);
                }
            }
            /**  structure json response */
            $result[$title] = [
                "type" => "object",
                "title" =>
                    \App::getLocale() == "ar"
                        ? $value->label_ar
                        : $requestData->title,
                "description" =>
                    \App::getLocale() == "ar"
                        ? $requestData->description_ar
                        : $requestData->description,
                "required" => $requiredField,
                "properties" => $properties,
            ];
            $resultUiSchema[$title] = $uiSchema;
        }

        $formSchema = [
            "id" => $this->id,
            "title" =>
                \App::getLocale() == "ar"
                    ? $this->requestType->title_ar
                    : $this->requestType->title,
            //  'User_type' =>  $typeUser->getUserType(),
            "release_version" => $this->requestType->release_version,
            "release_date" => $this->requestType->release_date,
            "type" => "object",
            "properties" => $result,
        ];

        $requestInfo = [
            "id" => $this->id,
            "notes" => $this->notes,
            "statusId" => $this->requestStatus->id,
            "status" =>
                \App::getLocale() == "ar"
                    ? $this->requestStatus->title_ar
                    : $this->requestStatus->title_en,
            "date_request" => $this->created_at->format("Y-m-d"),
            "profile" => $this->profile->user->getFullNameAttribute(),
            "request_type" =>
                \App::getLocale() == "ar"
                    ? $this->requestType->title_ar
                    : $this->requestType->title,
        ];


        /** Get Block Validation Steps */
        $stepAction = [];
        $arrayId = [];
        $showSetpAction = false ;
        $listIdRequests = \App::make('App\Domain\Requests\Services\RequestListInBoxService')->getListRequestInBox() ;

        if(in_array($this->id, $listIdRequests)) {
            $showSetpAction = true ;
        }

        $itemRequestSteps = RequestSteps::where("request_id", $this->id)
            ->where("status", 0)
            ->first();
        if (!empty($itemRequestSteps) and  $showSetpAction == true and $this->requestStatus->id == 1) {
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
            $stepAction = StepActionResource::collection($stepAction);
        }

        return [
            "requestInfo" => $requestInfo,
            "formSchema" => $formSchema,
            "uiSchema" => $resultUiSchema,
            "formData" => $resultFormData,
            "stepAction" =>  $stepAction,
        ];
    }
}
