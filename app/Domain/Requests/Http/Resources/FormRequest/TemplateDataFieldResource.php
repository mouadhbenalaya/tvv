<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\FormRequest;

use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataFieldChildResource ;
use App\Domain\Requests\Models\FieldType;
use  App\Domain\Requests\Http\Resources\FormRequest\FieldTypeTemlateResource ;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateDataFieldResource.
  *
 * @property int $id
 * @property string $label
 * @property string $field_name
 * @property FieldType $fieldType
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
            property: 'label',
            type: 'string',
        ),
        new Property(
            property: 'field_name',
            type: 'string',
        ),
        new Property(
            property: 'field_type',
            ref: '#/components/schemas/FieldTypeTemlateResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class TemplateDataFieldResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $resultat = [] ;

        if($this->enabled == 1) {

            $resultat =  [
                 'id' => $this->id ,
                 'label' =>   (\App::getLocale() == 'ar') ? $this->label_ar : $this->label  ,
               //  'required' => $this->required ,
                 'name_table_relationship' => $this->name_table_relationship ,
                 'type_data_table_relationship' => $this->type_data_table_relationship ,
                 'field_name' => $this->field_name ,
                 //    'enabled' => $this->enabled ,
                 'request_type' => $this->requestType !==  null ? new RequestTypeTemplateResource($this->requestType) : [] ,
                'field_type' => $this->fieldType !==  null ? new FieldTypeTemlateResource($this->fieldType, $this->label) : [] ,
                'template_data_field_child' =>  $this->templateDataField !==  null ? new TemplateDataFieldChildResource($this->templateDataField) : [] ,
            ];
        }

        return  $resultat ;

    }
}
