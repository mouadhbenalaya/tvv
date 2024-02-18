<?php

namespace App\Common\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\ResponseTrait;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes\Info;

#[Info(
    version: '1.0.0',
    title: 'Tamkeen',
)]
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ResponseTrait;

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }
}
