<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\FieldType;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;

readonly class FieldTypeRegisterService
{
    public function __construct(
    ) {
    }

    /**
     * Create New FieldType
     */
    public function createFieldType(array $requestData): FieldType
    {

        $item =   FieldType::create($requestData);

        return $item;
    }


}
