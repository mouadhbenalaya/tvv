<?php

namespace App\Domain\Users\Http\Resources\User;

use App\Common\Http\Resources\Residency\CityResource;
use App\Common\Http\Resources\Residency\CountryResource;
use App\Common\Http\Resources\Residency\RegionResource;
use App\Common\Models\City;
use App\Common\Models\Country;
use App\Common\Models\Region;
use App\Domain\Users\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * Class InvestorProfileResource.
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
 * @property string $employee_number
 * @property string $ad_user_name
 * @property int $department_id
 * @property int $facility_id
 * @property UserType $userType
 */
#[Schema(
    title: 'Profile resource',
    description: 'Profile resource',
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
            default: 'Wick',
        ),
        new Property(
            property: 'third_name',
            type: 'string',
            default: 'Junior',
        ),
        new Property(
            property: 'id_number',
            type: 'string',
            default: '123456',
        ),
        new Property(
            property: 'email',
            type: 'string',
            default: 'john@wick.com',
        ),
        new Property(
            property: 'mobile_number',
            type: 'string',
            default: '+38512345689',
        ),
        new Property(
            property: 'gender',
            type: 'string',
            default: 'm',
        ),
        new Property(
            property: 'lives_in_saudi_arabi',
            type: 'boolean',
            default: true,
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
            property: 'employee_number',
            type: 'string',
            default: '123',
        ),
        new Property(
            property: 'ad_user_name',
            type: 'string',
            example: 'username',
        ),
        new Property(
            property: 'department_id',
            type: 'int',
            example: '12345',
        ),
        new Property(
            property: 'facility_id',
            type: 'int',
            default: '12345',
        ),
        new Property(
            property: 'user_type',
            ref: '#/components/schemas/UserTypeResource',
            type: 'object',
        ),
    ],
    type: 'object'
)]
class InvestorProfileResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id ?? null,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'last_name' => $this->last_name,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'gender' => $this->gender,
            'lives_in_saudi_arabi' => $this->lives_in_saudi_arabi,
            'birth_date' => Carbon::parse($this->birth_date)->toIso8601String(),
            'country' => new CountryResource($this->country),
            'region' => new RegionResource($this->region),
            'city' => new CityResource($this->city),
            'nationality' => new CountryResource($this->nationality),
            'employee_number' => $this->employee_number,
            'ad_user_name' => $this->ad_user_name,
            'department_id' => $this->department_id,
            'facility_id' => $this->facility_id,
            'user_type' => new UserTypeResource($this->userType),
        ];
    }
}
