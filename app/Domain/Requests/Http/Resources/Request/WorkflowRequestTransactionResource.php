<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\Request;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class WorkflowRequestTransactionResource.
 *
 * @property int $id
 * @property string $title
 * @property string $color
 */
#[Schema(
    title: 'Workflow Request Transaction resource',
    description: 'Workflow Request Transaction resource',
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
class WorkflowRequestTransactionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        

        $date  = [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->requestSteps->step_title_ar : $this->requestSteps->step_title_en,
            'role' => (\App::getLocale() == 'ar') ? $this->profile->userType->name_ar : $this->profile->userType->name ,
            'color' => $this->stepAction->code_color
        ] ;

        return  $date ;
    }
}
