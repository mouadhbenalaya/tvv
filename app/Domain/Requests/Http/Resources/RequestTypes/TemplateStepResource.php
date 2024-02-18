<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Requests\Http\Resources\RequestShow\TypeRequestResource ;
use App\Domain\Requests\Http\Resources\RequestTypes\RequestPermissionResource ;
use App\Domain\Users\Models\RequestType;
use App\Domain\Users\Models\TemplateData;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class TemplateStepResource.
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
            property: 'title',
            type: 'string',
        ),
        new Property(
            property: 'request_type',
            ref: '#/components/schemas/TypeRequestResource',
            type: 'object',
        ),
        new Property(
            property: 'request_permission',
            ref: '#/components/schemas/RequestPermissionResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class TemplateStepResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        /**  structure json response */

        return   [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->step_title_ar : $this->step_title_en ,
            'step_sequence' => $this->step_sequence,
            'can_reject' => $this->can_reject,
            'can_return' => $this->can_return,
            'request_permission' => $this->requestPermission !==  null ? new RequestPermissionResource($this->requestPermission) : [] ,
            'request_type' => $this->requestPermission !==  null ? new TypeRequestResource($this->requestType) : [] ,

        ] ;
        ;
    }



}
