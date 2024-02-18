<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use App\Domain\Requests\Models\RequestTransaction;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Illuminate\Support\Facades\App;

/**
 * Class WorkflowRequestResource.
 *
 * @property int $id
 * @property string $title
 */
#[Schema(
    title: ' Request Transaction resource',
    description: ' Request Transaction resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),

        new Property(
            property: 'note',
            type: 'string',
        ),

        new Property(
            property: 'request_steps',
            type: 'string',
        ),

        new Property(
            property: 'step',
            type: 'string',
        ),

        new Property(
            property: 'profile',
            type: 'string',
        ),

        new Property(
            property: 'date_created',
            type: 'date',
        ),

    ],
    type: 'object'
)]
class WorkflowRequestResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        //  'request_steps_id',
        return [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->step_title_ar : $this->step_title_en   ,
            'status' => $this->status ,

        ];


    }
}
