<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\Request;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;

readonly class RequestListInBoxService
{
    public function __construct(
    ) {
    }

    /**
     * get List Request Inbox
     */
    public function getListRequestInBox(): array
    {

        // Get list Id Role by User Current
        $arrayIdRole =  auth()->user()?->currentProfile()->roles->pluck("id") ->toArray();



        $listIdRequests  =  \DB::table('request_stepss as request_steps')
         ->select('request_steps.request_id')
        ->join('request_permissions', 'request_steps.request_permission_id', '=', 'request_permissions.id')

        ->join('request_permission_role', 'request_permission_role.request_permission_id', '=', 'request_permissions.id')

        ->whereIn('request_permission_role.role_id', $arrayIdRole)
        ->where('request_steps.status', 0)
        ->whereNotExists(function ($query) {
            $query->select(\DB::raw(1))
                ->from('request_stepss')
                ->whereRaw('request_id=request_steps.request_id and step_sequence<request_steps.step_sequence and status=0');
        })
        ->pluck('request_steps.request_id')->toArray()  ;



        return $listIdRequests;
    }


    /**
     * get List Request Inbox
     */
    public function getListRequestNotReceived(): array
    {

        // Get list Id Role by User Current
        $arrayIdRole =  auth()->user()?->currentProfile()->roles->pluck("id") ->toArray();



        $listIdRequests  =  \DB::table('request_stepss as request_steps')
         ->select('request_steps.request_id')
        ->join('request_permissions', 'request_steps.request_permission_id', '=', 'request_permissions.id')

        ->join('request_permission_role', 'request_permission_role.request_permission_id', '=', 'request_permissions.id')

        ->whereIn('request_permission_role.role_id', $arrayIdRole)
        ->where('request_steps.status', 0)
        ->whereExists(function ($query) {
            $query->select(\DB::raw(1))
                ->from('request_stepss')
                ->whereRaw('request_id=request_steps.request_id and step_sequence<request_steps.step_sequence and status=0');
        })
        ->pluck('request_steps.request_id')->toArray()  ;



        return $listIdRequests;
    }

    /**
     * get List Request Send
     */
    public function getListRequestSend(): array
    {

        // Get list Id Role by User Current
        $arrayIdRole =  auth()->user()?->currentProfile()->roles->pluck("id") ->toArray();


        $listIdRequests  =  \DB::table('request_stepss as request_steps')
         ->select('request_steps.request_id')
        ->join('request_permissions', 'request_steps.request_permission_id', '=', 'request_permissions.id')

        ->join('request_permission_role', 'request_permission_role.request_permission_id', '=', 'request_permissions.id')

        ->whereIn('request_permission_role.role_id', $arrayIdRole)
        ->where('request_steps.status', 1)

        ->pluck('request_steps.request_id')->toArray()  ;



        return $listIdRequests;
    }


}
