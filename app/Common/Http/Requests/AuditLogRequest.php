<?php

declare(strict_types=1);

namespace App\Common\Http\Requests;

use App\Common\Http\Controllers\FormRequest;

class AuditLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        //TODO: fix this when we finish permissions
        return true;
    }

    public function rules(): array
    {
        return [
            'auditable_type' => ['required', 'string'],
            'auditable_id' => ['required', 'numeric'],
            'event' => ['required', 'string'],
            'payload' => ['required', 'json']
        ];
    }

    public function getData(): array
    {
        $data = $this->all();

        /** @var array $payloadArray */
        $payloadArray = json_decode(stripslashes($data['payload']), true, 512, JSON_THROW_ON_ERROR);

        $data['payload'] = collect($payloadArray);

        return $data;
    }

}
