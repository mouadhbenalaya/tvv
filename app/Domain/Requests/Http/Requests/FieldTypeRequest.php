<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\FieldType;
use Illuminate\Validation\Rule;

class FieldTypeRequest extends FormRequest
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
                'type_field' => ['string' , 'required' , 'nullable'],
                'class' => ['string', 'nullable'],
                'name' => ['string', 'required'],
                'name_field' => ['string', 'nullable'],
                'name_table_relationship' => ['string', 'nullable'],
                'enabled' => ['boolean', 'nullable'],

            ],
            'PUT', 'PATCH' => [
               'type_field' => ['string'   , 'nullable'],
               'class' => ['string', 'nullable'],
               'name_field' => ['string', 'nullable'],
               'name' => ['string', 'nullable'],
               'enabled' => ['boolean', 'nullable'],
               'name_table_relationship' => ['string', 'nullable'],

            ],
            default => []
        };
    }



    public function getFields(): array
    {
        return [ 'enabled',  'name' , 'class'    , 'name_table_relationship'  , 'type_field','name_field' ];
    }
}
