<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestShow;

use App\Domain\Requests\Models\RequestTransaction;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use Illuminate\Support\Facades\App;

/**
 * Class RequestTransactionResource.
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
class RequestTransactionResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        $step = "" ;
        if(!empty($this->stepAction)) {
        $step = (\App::getLocale() == 'ar') ? $this->stepAction->title_ar : $this->stepAction->title_en ;
         }

        return [
            'id' => $this->id,
            'note' => $this->note,
          //  'request_steps' =>  (\App::getLocale() == 'ar') ? $this->requestSteps->step_title_ar :    $this->requestSteps->step_title_en  ,
            'step' =>    $step ,
            'profile' => !empty($this->profile) ? $this->profile->user->getFullNameAttribute() : "" ,
            'role' => (\App::getLocale() == 'ar') ? $this->profile->userType->name_ar : $this->profile->userType->name ,
            'date_created' =>   $this->created_at->format('Y-m-d H:i:s')   ,
        ];


    }
}
