<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\TemplateStep;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;

readonly class TemplateStepService
{
    public function __construct(
    ) {
    }

    /**
     * Create New TemplateStep
     */
    public function createTemplateStep(array $requestData): TemplateStep
    {

        $item =   TemplateStep::create($requestData);

        return $item;
    }


}
