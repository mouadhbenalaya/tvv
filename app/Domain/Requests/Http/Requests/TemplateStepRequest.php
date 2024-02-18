<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\RequestPermission;
use Illuminate\Validation\Rule;

class TemplateStepRequest extends FormRequest
{
    public function __construct(
    ) {
        parent::__construct();
    }

    public function authorize(): bool
    {
        return match ($this->getMethod()) {
            'POST' => true,
            'PUT', 'PATCH' => true,
            'DELETE' => true,
            default => false
        };
    }

    public function rules(): array
    {


        return match ($this->getMethod()) {
            'POST' => [
                 'request_permission_id' => ['required', 'integer', Rule::in(
                     RequestPermission::select('id')->pluck('id')->toArray()
                 )],
                'request_type_id' => ['required', 'integer', Rule::in(
                    RequestType::select('id')->pluck('id')->toArray()
                )],
                'step_sequence' => ['integer', 'nullable'],
                'step_title_ar' => ['string', 'nullable'],
                'step_title_en' => ['string', 'nullable'],
                'can_return' => ['boolean', 'nullable'],
                'can_reject' => ['boolean', 'nullable']
            ],
            'PUT', 'PATCH' => [
               'request_permission_id' => ['required', 'integer', Rule::in(
                   RequestPermission::select('id')->pluck('id')->toArray()
               )],
               'request_type_id' => ['required', 'integer', Rule::in(
                   RequestType::select('id')->pluck('id')->toArray()
               )],
               'step_sequence' => ['integer', 'nullable'],
               'step_title_ar' => ['string', 'nullable'],
               'step_title_en' => ['string', 'nullable'],
               'can_return' => ['boolean', 'nullable'],
               'can_reject' => ['boolean', 'nullable']

            ],
            default => []
        };
    }



    public function getFields(): array
    {
        return [    'request_permission_id',  'request_type_id' , 'step_sequence' , 'step_title_ar' , 'step_title_en', 'can_reject' , 'can_return'  ];
    }
}
