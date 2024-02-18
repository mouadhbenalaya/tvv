<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\RequestCategory;
use Illuminate\Validation\Rule;

class RequestTypeRequest extends FormRequest
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
            'title' => ['string', 'nullable'],
            'link_get_data' => ['string', 'nullable'],
            'title_ar' => ['string', 'nullable'],
                'desc_short_ar' => ['string', 'nullable'],
                'desc_short_en' => ['string', 'nullable'],
                'desc_long_ar' => ['string', 'nullable'],
                'desc_long_en' => ['string', 'nullable'],
                'release_version' => ['string', 'nullable'],
            'request_type_id' => ['integer', 'nullable'],
            'enabled' => ['boolean', 'nullable'],
            'request_category_id' => [null, 'integer', Rule::in(
                RequestCategory::select('id')->pluck('id')->toArray()
            )],
            ],
            'PUT', 'PATCH' => [
               'title' => ['string', 'nullable'],
               'link_get_data' => ['string', 'nullable'],
               'title_ar' => ['string', 'nullable'],
                   'desc_short_ar' => ['string', 'nullable'],
                   'desc_short_en' => ['string', 'nullable'],
                   'desc_long_ar' => ['string', 'nullable'],
                   'desc_long_en' => ['string', 'nullable'],
                   'release_version' => ['string', 'nullable'],
               'request_type_id' => ['integer', 'nullable'],
               'enabled' => ['boolean', 'nullable'],
               'request_category_id' => [null, 'integer', Rule::in(
                   RequestCategory::select('id')->pluck('id')->toArray()
               )],
            ],
            default => []
        };
    }



    public function getFields(): array
    {
        return [
            'enabled','title_ar' ,'desc_short_ar' ,'desc_short_en' ,'desc_long_ar' ,'desc_long_en' ,'link_get_data',
            'title' , 'release_date','release_version' , 'request_category_id' , 'request_type_id'
        ];
    }
}
