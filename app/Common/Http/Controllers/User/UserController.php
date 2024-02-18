<?php

namespace App\Common\Http\Controllers\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\ResponseTrait;
use Illuminate\Routing\Controller as BaseController;

use App\Domain\Users\Http\Resources\User\UserTypeResource;
use App\Domain\Users\Models\UserType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends BaseController
{
    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    public function getUserType(): ResourceCollection
    {

        $userTypes = UserType::all();
        return UserTypeResource::collection($userTypes);
    }
}
