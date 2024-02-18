<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Resources\User;

use App\Common\Http\Resources\Residency\CityResource;
use App\Domain\Users\Http\Resources\User\UserResource;
use App\Common\Models\City;
use App\Domain\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class UserTvtcOperatorCitieResource.
 *
 * @property int $id
 * @property City $city
 * @property User $user
 */
#[Schema(
    title: 'User TvtcOperator Citie  resource',
    description: ' User TvtcOperator Citie   resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),

        new Property(
            property: 'city',
            ref: '#/components/schemas/CityResource',
            type: 'object',
        ),
        new Property(
            property: 'user',
            ref: '#/components/schemas/UserResource',
            type: 'object',
        ),

    ],
    type: 'object'
)]
class UserTvtcOperatorCitieResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'city' => new CityResource($this->city),
            'city' => new UserResource($this->user),
        ];
    }
}
