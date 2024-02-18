<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\FormRequest;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use App\Domain\Requests\Models\FieldType;

/**
 * Class FieldTypeRequestResource.
 *
 * @property int $id
 * @property boolean $enabled
 * @property string $name
 * @property string $class
 * @property string $name_field
 * @property string $type_field
 */
#[Schema(
    title: 'FieldType  resource',
    description: 'FieldType resource',
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
            property: 'name_table_relationship',
            type: 'string',
        ),
        new Property(
            property: 'name_field',
            type: 'string',
        ),
        new Property(
            property: 'name',
            type: 'string',
        ),
        new Property(
            property: 'class',
            type: 'string',
        ),
        new Property(
            property: 'type_field',
            type: 'string',
        ),
       /* new Property(
            property: 'field_type_resource',
            ref: '#/components/schemas/FieldTypeResource',
            type: 'object',
        ),*/
    ],
    type: 'object'
)]
class FieldTypeResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {


        $result [$this->name] =  [
            'id' => $this->id,
            'enabled' => $this->enabled,
            'type' => $this->type_field,
            'name' => $this->name,
            'class' => $this->class,
            'name_field' => $this->name_field,
            'name_table_relationship' => $this->name_table_relationship,

        //    'field_type_child' =>  $this->fieldType !==  null ?  new FieldTypeResource($this->fieldType )  : [] ,

           ] ;
        return     $result;

    }
}
