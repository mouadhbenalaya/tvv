<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use App\Domain\Requests\Http\Resources\FormRequest\TemplateDataFieldChildResource ;
use App\Domain\Requests\Models\FieldType;
use  App\Domain\Requests\Http\Resources\RequestShow\FieldTypeRequestResource ;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateDataFieldResource.
  *
 * @property int $id
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
            property: 'field_type',
            ref: '#/components/schemas/FieldTypeRequestResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class TemplateRequestDataFieldResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $resultat = [] ;



        $resultat =  [
           // 'id' => $this->id ,
         'label' => $this->label ,
            'field_value' => $this->field_value ,
          //  'request_type' => $this->requestType !==  null ? new RequestTypeTemplateResource($this->requestType): [] ,
            'field_type' => $this->fieldType !==  null ? new FieldTypeRequestResource($this->fieldType, $this->label, $this->field_value) : [] ,
         //   'template_data_field_child' =>  $this->templateDataField !==  null ?  new TemplateRequestDataFieldResource($this->templateDataField )  : [] ,
        ];


        return  $resultat ;

    }
}
