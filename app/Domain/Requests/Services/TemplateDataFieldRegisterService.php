<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\TemplateDataField;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;

readonly class TemplateDataFieldRegisterService
{
    public function __construct(
    ) {
    }

    /**
     * Create New FieldType
     */
    public function createTemplateDataField(array $requestData): TemplateDataField
    {

        $item =   TemplateDataField::create($requestData);

        return $item;
    }


}
