<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class WorkflowRequestStepsResource.
 *
 * @property int $id
 * @property string $title
 * @property string $color
 */
#[Schema(
    title: 'Workflow Request Steps resource',
    description: 'Workflow Request Steps resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),

        new Property(
            property: 'title',
            type: 'string',
        ),

        new Property(
            property: 'color',
            type: 'string',
        ),


    ],
    type: 'object'
)]
class WorkflowRequestStepsResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {


        $date  = [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->step_title_ar : $this->step_title_en,
            'role' => (\App::getLocale() == 'ar') ? $this->requestPermission->userType->name_ar : $this->requestPermission->userType->name ,
            'color' => "#7f7f7f"   ,

        ] ;

        return  $date ;
    }
}
