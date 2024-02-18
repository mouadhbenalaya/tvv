<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\FieldType;
use Illuminate\Validation\Rule;

class TemplateDataRequest extends FormRequest
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
                'type_data' => ['string', 'nullable'],
                'title' => ['string', 'nullable'],
                'description' => ['string', 'nullable'],
                 'enabled' => ['boolean', 'nullable'],
                 'request_type_id' => ['required', 'integer', Rule::in(
                     RequestType::select('id')->pluck('id')->toArray()
                 )],

                'template_data_id' => [null, 'integer', Rule::in(
                    TemplateData::select('id')->pluck('id')->toArray()
                )],

                'field_type_id' => [null, 'integer', Rule::in(
                    FieldType::select('id')->pluck('id')->toArray()
                )],

            ],
            'PUT', 'PATCH' => [
               'type_data' => ['string', 'nullable'],
               'title' => ['string', 'nullable'],
               'description' => ['string', 'nullable'],
                'enabled' => ['boolean', 'nullable'],
                'request_type_id' => ['required', 'integer', Rule::in(
                    RequestType::select('id')->pluck('id')->toArray()
                )],

               'template_data_id' => [null, 'integer', Rule::in(
                   TemplateData::select('id')->pluck('id')->toArray()
               )],

            ],
            default => []
        };
    }



    public function getFields(): array
    {
        return [
            'enabled',
            'title',
            'description',
            'type_data',
            'template_data_id',
            'request_type_id'
        ];
    }
}
