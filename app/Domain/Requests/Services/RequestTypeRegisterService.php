<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\RequestType;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;

readonly class RequestTypeRegisterService
{
    public function __construct(
    ) {
    }

    /**
     * Create New RequestType
     */
    public function createRequestType(array $requestData): RequestType
    {
        if($requestData['enabled'] == 1) {

            $requestData['release_date'] = date("Y-m-d H:i:s");

            if(!empty($requestData['request_type_id'])) {
                $entities = RequestType::where('enabled', 1)->where('id', $requestData['request_type_id'])->orWhere('request_type_id', $requestData['request_type_id'])->get();
                foreach($entities  as $value) {
                    $value->enabled = 0 ;
                    $value->save();
                }
            }

        }


        $item =   RequestType::create($requestData);




        return $item;
    }


}
