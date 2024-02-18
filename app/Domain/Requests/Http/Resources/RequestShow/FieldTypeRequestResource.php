<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

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
 * @property FieldType $field_type_resource
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
        new Property(
            property: 'field_type_resource',
            ref: '#/components/schemas/FieldTypeRequestResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class FieldTypeRequestResource extends JsonResource
{
    private $titleField;
    private $valueField;
    private $request;
    public function __construct($request, $titleField, $valueField)
    {
        // Ensure you call the parent constructor
        parent::__construct($request);
        $this->request = $request;

        $this->titleField = $titleField;
        $this->valueField = $valueField;
    }



    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $result  = [] ;
        if($this->enabled = 1) {

            $result  =  [
                'id' => $this->id,
                'name' => $this->name ,
                'valueField' => $this->valueField ,
                'type_field' => $this->type_field,
                'class' => $this->class,
                'name_field' => $this->name_field,
                'name_table_relationship' => $this->name_table_relationship,
                'title' => $this->titleField ,
            //  'field_type_child' =>  $this->fieldType !==  null ?  new FieldTypeResource($this->fieldType )  : [] ,

               ] ;

        }
        return     $result;

    }
}
