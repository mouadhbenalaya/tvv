<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\RequestPermissionRole;
use phpDocumentor\Reflection\Types\Boolean;

readonly class RequestPermissionRoleRegisterService
{
    public function __construct(
    ) {
    }


    /**
        * Create New RequestPermissionRole
        */
    public function create($roleId, array $listPermissionId): bool
    {
        $data = [] ;
        $entities = null ;
        foreach($listPermissionId as $key => $value) {
            $data[$key]['role_id'] = $roleId  ;
            $data[$key]['request_permission_id']  = $value ;

        }

        if(!empty($data)) {
            $entities = RequestPermissionRole::insert($data);
        }


        return  $entities;
    }


}
