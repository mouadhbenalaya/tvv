<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\TemplateDataField;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use App\Domain\Requests\Services\integer ;

readonly class TemplateDataRegisterService
{
    public function __construct(
    ) {
    }

    /**
     * Create New TemplateData
     */
    public function createTemplateFrom(array $requestData): TemplateData
    {

        $item =   TemplateData::create($requestData);

        return $item;
    }

    /**
        * Create New TemplateData
        */
    public function createTemplateDataField(array $requestData, array $listLabel, array $listFieldName, array $listTableRelationship, array $listTypeDataRelationship, array $listRequiredDataField, array $listReadonlyDataField, $idTemplate): void
    {
        $data = [] ;
        foreach($requestData as $key => $value) {
            $data[$key]['label'] = $listLabel[$key];
            $data[$key]['field_name'] = $listFieldName[$key];
            $data[$key]['required'] = $listRequiredDataField[$key];
            $data[$key]['readonly'] = $listReadonlyDataField[$key];
            if(!empty($listTableRelationship[$key])) {
                $data[$key]['name_table_relationship'] = $listTableRelationship[$key];
            }
            if(!empty($listTypeDataRelationship[$key])) {
                $data[$key]['type_data_table_relationship'] = $listTypeDataRelationship[$key];
            }
            $data[$key]['field_type_id']  = $value ;
            $data[$key]['template_data_id']  = $idTemplate ;

        }
        if(!empty($data)) {
            TemplateDataField::insert($data);
        }



    }


}
