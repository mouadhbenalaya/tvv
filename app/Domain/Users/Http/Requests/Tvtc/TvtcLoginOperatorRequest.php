<?php

declare(strict_types=1);

namespace App\Domain\Users\Http\Requests\Tvtc;

use App\Common\Http\Controllers\FormRequest;

class TvtcLoginOperatorRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => [
                'id_number' => ['string', 'required'],
                'password' => ['string', 'required'],
            ],
            default => []
        };
    }
}
