<?php

namespace App\Domain\Requests\Http\Controllers\Request;

use App\Domain\Requests\Http\Resources\RequestShow\RequestInBoxResource;
use App\Common\Http\Controllers\Controller;
use App\Domain\Requests\Models\Request as ModelsRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Get;
use App\Common\Services\SearchService;
use App\Common\Http\Requests\Search\DefaultSearchRequest;
use App\Domain\Requests\Services\RequestListInBoxService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Parameter;

use App\Domain\Users\Models\UserTvtcOperatorCitie ;

use OpenApi\Attributes\Schema;
use Illuminate\Http\Request;

class ListRequestInBoxController extends Controller
{
    /**
    * @param SearchService $searchService
    * @param RequestListInBoxService $requestListInBoxService
    */
    public function __construct(
        private readonly RequestListInBoxService $requestListInBoxService,
        private readonly SearchService $searchService
    ) {
    }

    #[Get(
        path: '/api/v1/inbox/list-requests',
        summary: 'Get request by Role',
        security: [['sanctum' => []]],
        tags: ["Request"],
        parameters: [
            new Parameter(
                name: 'query',
                description: 'Enter the query string to search for (will search all string fields of the entity)',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'orderBy',
                description: 'Sort by this field name',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: 'id',
                ),
            ),
            new Parameter(
                name: 'direction',
                description: 'Sorting direction - ASC or DESC',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: 'DESC',
                ),
            ),
            new Parameter(
                name: 'paginate',
                description: 'Active or inactive users - true or false',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'boolean',
                    default: null,
                ),
            ),
            new Parameter(
                name: 'page',
                description: 'Enter the page number to show',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: '1',
                ),
            ),
            new Parameter(
                name: 'limit',
                description: 'Enter the number of result items to show on a page',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    default: '10',
                ),
            ),
            new Parameter(
                name: 'locale',
                description: 'Language locale',
                in: 'query',
                required: false,
                schema: new Schema(
                    type: 'string',
                    enum: [
                        'en',
                        'ar',
                    ],
                ),
            ),
            new Parameter(
                name: 'typeInbox',
                description: 'Get List requests by typeInbox',
                in: 'query',
                required: false,
                example: "inbox|not_received|send|finished|all",
                schema: new Schema(
                    type: 'string',
                ),
            ),
            new Parameter(
                name: 'numberRequest',
                description: 'Get List requests by numberRequest',
                in: 'query',
                required: false,
                example: "48",
                schema: new Schema(
                    type: 'number',
                ),
            ),
            new Parameter(
                name: 'titleTypeRequest',
                description: 'Get List requests by titleTypeRequest',
                in: 'query',
                required: false,
                example: "Issuing the license",
                schema: new Schema(
                    type: 'string',
                ),
            ),
            new Parameter(
                name: 'requestStatus',
                description: 'Get List requests by requestStatus',
                in: 'query',
                required: false,
                example: "1",
                schema: new Schema(
                    type: 'number',
                ),
            ),
            new Parameter(
                name: 'startDate',
                description: 'Get List requests by startDate',
                in: 'query',
                required: false,
                example: "2024-01-10",
                schema: new Schema(
                    type: 'date',
                ),
            ),
            new Parameter(
                name: 'endDate',
                description: 'Get List requests by endDate',
                in: 'query',
                required: false,
                example: "2024-01-10",
                schema: new Schema(
                    type: 'date',
                ),
            ),

        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'Success',
                content: new JsonContent(
                    ref: '#/components/schemas/RequestInBoxResource',
                ),
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 401,
                description: 'Unauthorized',
            ),
            new \OpenApi\Attributes\Response(
                response: 404,
                description: 'Not found',
            ),
        ],
    )]
    public function __invoke(DefaultSearchRequest $request, Request $currentRequest): ResourceCollection
    {

        // userTypeId by User Current
        $userTypeId =  auth()->user()?->currentProfile()->user_type_id ;

        $typeInbox = $currentRequest->query->get('typeInbox');
        $numberRequest = $currentRequest->query->get('numberRequest');
        $requestStatus = $currentRequest->query->get('requestStatus');
        $endDate = $currentRequest->query->get('endDate');
        $startDate = $currentRequest->query->get('startDate');
        $titleTypeRequest = $currentRequest->query->get('titleTypeRequest');

        $listIdRequests = null ;
        $listRequests = null ;

        switch ($typeInbox) {
            case 'inbox':
                /** get List Request Inbox  */
                $listIdRequests = $this->requestListInBoxService->getListRequestInBox();

                break;
            case 'not_received':
                /** get List Request Not received  */
                $listIdRequests = $this->requestListInBoxService->getListRequestNotReceived();

                break;
            case 'send':
                /** get List Request Send  */
                $listIdRequests = $this->requestListInBoxService->getListRequestSend();
                break;
        }


        $query = ModelsRequest::query();
        if($typeInbox == 'finished') {
            $query =   $query->whereIn('request_status_id', [ 2 ,3 , 4]) ;
        } elseif (!empty($listIdRequests)) {

            $query =  $query->whereIn('request_status_id', [null , 1])->whereIn('id', $listIdRequests) ;
        }

        if (null !== $numberRequest) {
            $query = $query->where('id', $numberRequest);
        }
        if (null !== $requestStatus) {
            $query = $query->where('request_status_id', $requestStatus);
        }
        if (null !== $startDate) {
            $query = $query->whereDate('created_at', '>=', $startDate);
        }

        if (null !== $endDate) {
            $query = $query->whereDate('created_at', '<=', $endDate);
        }
        if (null !== $titleTypeRequest) {
            $query = $query->whereHas('requestType', function ($query) use ($titleTypeRequest) {
                return   $query = $query->where('title', 'LIKE', "%$titleTypeRequest%")->orWhere('title_ar', 'LIKE', "%$titleTypeRequest%");
            });
        }
        switch ($userTypeId) {
            case 1:
                /** EstablishmentOperator test By est_id == profil.facility_id  */
                $facilityId =  auth()->user()?->currentProfile()->facility_id ;
                $query =   $query->where('establishmed_id', $facilityId) ;
                break;
            case 2:

                /** Trainer test By Trainer_Profile_Id = profil.id*/

                $profilId =  auth()->user()?->currentProfile()->id ;
                $query =   $query->where('trainer_profile_id', $profilId) ;
                break;

            case 3:
                /** Trainee test By Trainee_Profile_Id = profil.id */

                $profilId =  auth()->user()?->currentProfile()->id ;
                $query =   $query->where('trainee_profile_id', $profilId) ;
                break;
            case 4:
                /** TvtcOperator test By City_id */

                $listIdCitys = UserTvtcOperatorCitie::where('user_id', auth()->user()->id)->pluck('city_id') ->toArray() ;
                $query =   $query->whereIn('citie_id', $listIdCitys) ;
                break;

        }



        $listRequests = $this->searchService->search($query, $request);



        return  RequestInBoxResource::collection($listRequests);


    }
}
