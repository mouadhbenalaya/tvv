<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Resources\User;

use App\Common\Http\Resources\Residency\CityResource;
use App\Common\Http\Resources\Residency\CountryResource;
use App\Common\Http\Resources\Residency\RegionResource;
use App\Common\Models\City;
use App\Common\Models\Country;
use App\Common\Models\Region;
use App\Domain\Users\Http\Resources\Gender\GenderResource;
use App\Domain\Users\Models\Profile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class UserResource.
 *
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string $third_name
 * @property string $last_name
 * @property string $id_number
 * @property string $email
 * @property string $mobile_number
 * @property string $gender
 * @property bool $lives_in_saudi_arabi
 * @property string $birth_date
 * @property Country $country
 * @property Region $region
 * @property City $city
 * @property Country $nationality
 * @property string $locale
 * @property Collection $profiles
 * @method Profile|null currentProfile()
 */
#[Schema(
    title: 'User resource',
    description: 'User resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'first_name',
            type: 'string',
            default: 'John',
        ),
        new Property(
            property: 'second_name',
            type: 'string',
            example: 'Second',
        ),
        new Property(
            property: 'third_name',
            type: 'string',
            example: 'Third',
        ),
        new Property(
            property: 'last_name',
            type: 'string',
            default: 'Doe',
        ),
        new Property(
            property: 'id_number',
            type: 'string',
            default: '0123456789',
        ),
        new Property(
            property: 'email',
            type: 'string',
            default: 'john.doe@q.agency',
        ),
        new Property(
            property: 'mobile_number',
            type: 'string',
            example: '09876543210',
        ),
        new Property(
            property: 'gender',
            ref: '#/components/schemas/GenderResource',
            type: 'object',
        ),
        new Property(
            property: 'lives_in_saudi_arabi',
            type: 'boolean',
            example: true,
        ),
        new Property(
            property: 'birth_date',
            type: 'string',
            example: '1985-01-01',
        ),
        new Property(
            property: 'country',
            ref: '#/components/schemas/CountryResource',
            type: 'object',
        ),
        new Property(
            property: 'region',
            ref: '#/components/schemas/RegionResource',
            type: 'object',
        ),
        new Property(
            property: 'city',
            ref: '#/components/schemas/CityResource',
            type: 'object',
        ),
        new Property(
            property: 'nationality',
            ref: '#/components/schemas/CountryResource',
            type: 'object',
        ),
        new Property(
            property: 'current_profile',
            ref: '#/components/schemas/ProfileResource',
            type: 'object',
        ),
        new Property(
            property: 'profiles',
            ref: '#/components/schemas/ProfileResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class UserResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'last_name' => $this->last_name,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'gender' => new GenderResource($this->gender),
            'lives_in_saudi_arabi' => $this->lives_in_saudi_arabi,
            'birth_date' => Carbon::parse($this->birth_date)->toIso8601String(),
            'country' => new CountryResource($this->country),
            'region' => new RegionResource($this->region),
            'city' => new CityResource($this->city),
            'locale' => $this->locale,
            'nationality' => new CountryResource($this->nationality),
            'current_profile' => new ProfileResource($this->currentProfile()?->load('roles')),
            'profiles' => ProfileResource::collection($this->profiles),
        ];
    }
}
