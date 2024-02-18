<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Requests;

use App\Common\Http\Controllers\FormRequest;
use App\Domain\Requests\Models\RequestPermissionRole;
use App\Domain\Users\Models\Role;
use Illuminate\Validation\Rule;

class RequestPermissionRoleRequest extends FormRequest
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
                'role_id' => [null, 'integer', Rule::in(
                    Role::select('id')->pluck('id')->toArray()
                )],
                'request_permission_id' => [[], 'required'],
               /* '' => [null, [], Rule::in(
                    RequestPermissionRole::select('id')->pluck('id')->toArray()
                )],*/


            ],
            'PUT', 'PATCH' => [
               'role_id' => [null, 'integer', Rule::in(
                   Role::select('id')->pluck('id')->toArray()
               )],
               'request_permission_id' => [[], 'required'],
               /*  'request_permission_id' => [null, [], Rule::in(
                   RequestPermissionRole::select('id')->pluck('id')->toArray()
               )],*/


            ],
            default => []
        };
    }



    public function getFields(): array
    {
        return [  'request_permission_id' , 'role_id'  ];
    }
}
