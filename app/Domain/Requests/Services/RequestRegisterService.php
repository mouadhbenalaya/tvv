<?php

namespace  App\Domain\Requests\Services;

use App\Domain\Requests\Models\Request;
use App\Domain\Requests\Models\RequestData;
use App\Domain\Requests\Models\RequestStatus;
use App\Domain\Requests\Models\RequestSteps;
use App\Domain\Requests\Models\RequestTransaction;
use App\Domain\Requests\Models\StepAction;
use App\Domain\Requests\Models\TemplateStep;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use App\Domain\Requests\Services\integer ;

readonly class RequestRegisterService
{
    public function __construct(
    ) {
    }

    /**
     * Create New Request
     */
    public function createRequest(array $requestData): Request
    {

        $requestStatus = RequestStatus::firstOrFail()->id ;
        $item =   Request::create($requestData);

        $item->request_status_id = $requestStatus;
        $item->save() ;
        return $item;
    }

    /**
     * Create New RequestData
     */
    public function createRequestData(array $requestData): RequestData
    {
        $item = null ;
        if(!empty($requestData)) {
            $item =    RequestData::create($requestData);
        }

        return  $item;
    }


    /**
     * Create New RequestData
     */
    public function getInfoRequest(Request $request   ): void
    { 
        // userTypeId by User Current
        $userTypeId =  auth()->user()?->currentProfile()->user_type_id ;

        switch ($userTypeId) {
            case 1:
                /** EstablishmentOperator test By est_id == profil.facility_id  */
                $facilityId =  auth()->user()?->currentProfile()->facility_id ;
                $request-> establishmed_id  = $facilityId ;

                break;
            case 2:

                /** Trainer test By Trainer_Profile_Id = profil.id*/

                $profilId =  auth()->user()?->currentProfile()->id ;
                $request-> trainer_profile_id  = $profilId  ;

                break;

            case 3:
                /** Trainee test By Trainee_Profile_Id = profil.id */

                $profilId =  auth()->user()?->currentProfile()->id ;
                $request-> trainee_profile_id  = $profilId  ;

                break;
            case 4:
                /** TvtcOperator test By City_id */

                $listIdCitys = UserTvtcOperatorCitie::where('user_id', auth()->user()->id)->pluck('city_id') ->first() ;
                if(!empty($listIdCitys)) {
                    $request-> citie_id  = $listIdCitys ->   city_id ;
                }

                break;

        }
        $request->save();
 
        
    }


    /**
     * Create New RequestSteps
     */
    public function createRequestSteps(Request $request): void
    {
        $enities = TemplateStep::where("request_type_id", $request->request_type_id)->orderBy('step_sequence', 'ASC')->get();
        $status = 1 ;
        $data = [] ;
        foreach($enities as $key => $value) {

            $data[$key]['status'] =  $status ;
            $data[$key]['step_sequence'] =  $value->step_sequence;
            $data[$key]['step_title_en'] =  $value->step_title_en;
            $data[$key]['step_title_ar'] =  $value->step_title_ar;
            $data[$key]['can_reject'] =  $value->can_reject;
            $data[$key]['can_return'] =  $value->can_return;
            $data[$key]['request_id'] =  $request->id ;
            $data[$key]['template_step_id'] =  $value->id ;
            $data[$key]['request_permission_id'] =   $value->request_permission_id ;
            $data[$key]['created_at'] =  date('Y-m-d H:i:s') ;
            $data[$key]['updated_at'] =  date('Y-m-d H:i:s') ;
            $status = 0 ;

        }
        if(!empty($data)) {
            RequestSteps::insert($data);

            $requestStepId = RequestSteps::where("request_id", $request->id)->where('status', 1)->first()?->id;
            $requestId = $request->id ;
            $profileId = $request->profile->id ;
            $stepActionId = StepAction::orderBy('id', 'ASC')->first()->id ;

            $item = new RequestTransaction();
            $item ->request_steps_id  =  $requestStepId ;
            $item ->request_id  =  $requestId  ;
            $item ->profile_id  =   $profileId ;
            $item ->step_action_id  =  $stepActionId ;
            $item -> save();
        }


    }


}
