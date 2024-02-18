<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Users\Models\RequestType;
use App\Domain\Users\Models\TemplateData;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateDataRequestResource.
 *
 * @property int $id
 * @property boolean $enabled
 * @property string $description
 * @property string $type_data
 * @property string $title
 * @property RequestType $requestType
 */
#[Schema(
    title: 'TemplateData resource',
    description: 'TemplateData resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'enabled',
            type: 'boolean',
            default: 1,
        ),
        new Property(
            property: 'description',
            type: 'string',
        ),
        new Property(
            property: 'title',
            type: 'string',
        ),
        new Property(
            property: 'template_data_child',
            ref: '#/components/schemas/TemplateDataRequestResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class TemplateDataRequestResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $properties = [] ;
        $result = [] ;


        if($this->enabled == 1) {
            $entities = $this->templateDataFields ;
            foreach($entities as $key => $value) {

                /** Structure json for type radio */
                if($value->fieldType->name_field == "radio") {
                    $oneOf[$key ] = [
                        "const" =>  $value->label,
                        "title" =>  $value->label ,

                    ] ;
                    $properties[$value->field_name] = [
                      //  'id' => $value->fieldType->id,
                        'type' => $value->fieldType->type_field,
                        'class' => $value->fieldType->class,
                       // 'title' => $value->label,
                       'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                        'name_field' => $value->fieldType->name_field,
                        'name_table_relationship' => $value->fieldType->name_table_relationship,
                        "oneOf" => $oneOf

                    ];
                }

                /** Structure json for type checkbox */
                elseif($value->fieldType->name_field == "checkbox") {
                    $enum = [
                            $value->label,

                    ] ;
                    $properties[$value->field_name] = [
                        //   'id' => $value->fieldType->id,
                        'type' => $value->fieldType->type_field,
                        'class' => $value->fieldType->class,
                        'name_field' => $value->fieldType->name_field,
                        'title' => $value->label,
                        'name_table_relationship' => $value->fieldType->name_table_relationship,
                        "items" => [ "type" => "string",
                        "enum" => $enum] ,
                            "uniqueItems" => true

                    ];
                }

                /** Structure json for type select */
                elseif($value->fieldType->name_field == "select") {
                    $valueSelect = null ;
                    if(empty($valueSelect)) {
                        $valueSelect = $value->label ;
                    }

                    $enum[$key ] = [
                            $value->label,

                    ] ;
                    $properties[$value->field_name] = [
                        //   'id' => $value->fieldType->id,
                        'type' => $value->fieldType->type_field,
                        'class' => $value->fieldType->class,
                        'name_field' => $value->fieldType->name_field,
                        'title' => $value->label,
                        'name_table_relationship' => $value->fieldType->name_table_relationship,
                        "enum" => $enum ,
                        "default" => $valueSelect

                    ];
                }

                /** Structure json for other type  */
                else {
                    $properties[$value->field_name] = [
                       //     'id' => $value->fieldType->id,
                        'type' => $value->fieldType->type_field,
                        'class' => $value->fieldType->class,
                        'name_field' => $value->fieldType->name_field,
                        'title' => $value->label,
                        'name_table_relationship' => $value->fieldType->name_table_relationship,

                    ];
                }

            }

            /**  structure json response */
            $result =   [
                'id' => $this->id,
                'title' =>  (\App::getLocale() == 'ar') ? $this->title_ar : $this->title  ,
                'description' =>  (\App::getLocale() == 'ar') ? $this->description_ar : $this->description   ,
                'properties' => $properties  ,
            ] ;
        }
        return  $result;
    }



}
