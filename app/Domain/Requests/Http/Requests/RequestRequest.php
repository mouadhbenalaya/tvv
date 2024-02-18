<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\Request;
use App\Domain\Requests\Models\RequestStatus;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Users\Models\Profile;
use Illuminate\Validation\Rule;

class RequestRequest extends FormRequest
{
    public function __construct(
    ) {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return match ($this->getMethod()) {
            'POST' => true,
            'DELETE' => true,
            default => false
        };
    }

    public function rules(): array
    {

        return match ($this->getMethod()) {
            'POST' => [
                'notes' => ['string'  , 'nullable'],

                'profile_id' => [null, 'integer', Rule::in(
                    Profile::select('id')->pluck('id')->toArray()
                )],
                'request_type_id' => [null, 'integer', Rule::in(
                    RequestType::select('id')->pluck('id')->toArray()
                )],
                'request_status_id' => [null, 'integer', Rule::in(
                    RequestStatus::select('id')->pluck('id')->toArray()
                )],

            ],

            default => []
        };
    }



    public function getFields(): array
    {
        return [ 'notes',  'profile_id' , 'request_type_id' , 'request_status_id' ];
    }
}
