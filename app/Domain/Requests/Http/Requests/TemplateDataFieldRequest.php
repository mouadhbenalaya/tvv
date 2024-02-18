<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\TemplateDataField;
use Illuminate\Validation\Rule;

class TemplateDataFieldRequest extends FormRequest
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
            'required' => ['integer' , 'required' ],
            'readonly' => ['integer' , 'readonly' ],
            'label_ar' => ['string' , 'required' ],
            'label' => ['string' , 'required' ],
            'name_table_relationship' => ['string' , 'nullable' ],
            'type_data_table_relationship' => ['string' , 'nullable' ],
            'field_name' => ['string' , 'required' ],
            'field_type_id' => ['integer' , 'required' ],
            'template_data_id' => ['integer', 'required'],
            'enabled' => ['boolean', 'nullable'],
            'template_data_field_id' => ['nullable', 'integer', Rule::in(
                TemplateDataField::select('id')->pluck('id')->toArray()
            )],
            ],

            default => []
        };
    }



    public function getFields(): array
    {
        return [ 'field_type_id', 'label','field_name' , 'label_ar' , 'name_table_relationship', 'readonly' , 'required' , 'type_data_table_relationship' , 'template_data_id', 'enabled' , 'template_data_field_id'  ];
    }
}
