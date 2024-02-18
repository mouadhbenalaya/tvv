<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\FormRequest;

use App\Domain\Requests\Models\FieldType;
use  App\Domain\Requests\Http\Resources\FormRequest\FieldTypeTemlateResource ;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateDataFieldChildResource.
  *
 * @property int $id
 * @property string $field_name
 * @property string $label
 * @property FieldType $fieldType
 * @property TemplateDataField  $templateDataField
 */
#[Schema(
    title: 'TemplateDataField resource',
    description: 'TemplateDataField resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'field_name',
            type: 'string',
        ),
        new Property(
            property: 'label',
            type: 'string',
        ),
        new Property(
            property: 'field_type',
            ref: '#/components/schemas/FieldTypeTemlateResource',
            type: 'object',
        ),
        new Property(
            property: 'template_data_field_child',
            ref: '#/components/schemas/TemplateDataFieldChildResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class TemplateDataFieldChildResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $result = [] ;
        $result = [
            //'id' => $this->id ,
            'label' =>  (\App::getLocale() == 'ar') ? $this->label_ar : $this->label ,
            'field_name' => $this->field_name ,
            'name_table_relationship' => $this->name_table_relationship ,
            'type_data_table_relationship' => $this->type_data_table_relationship ,
            //'enabled' => $this->enabled ,
             //'request_type' => $this->requestType !==  null ? new RequestTypeTemplateResource($this->requestType): [] ,
             'field_type' => $this->fieldType !==  null ? new FieldTypeTemlateResource($this->fieldType, $this->label) : [] ,
             'template_data_field_child' =>  $this->templateDataField !==  null ? new TemplateDataFieldChildResource($this->templateDataField) : [] ,

        ] ;

        return  $result;


    }
}
