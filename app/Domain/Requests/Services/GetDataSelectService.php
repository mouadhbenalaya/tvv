<?php

namespace App\Domain\Requests\Services;

use App\Common\Models\Country;
use App\Domain\Requests\Models\TemplateStep;
use App\Domain\Requests\Models\WfLookups;
use App\Domain\Users\Notifications\Registration\UserRegisteredSuccessfully;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Domain\Requests\Http\Resources\RequestTypes\DataSelectResource;

readonly class GetDataSelectService
{
    public function __construct()
    {
    }

    /**
     * Create New TemplateStep
     */
    public function getDatas($nameTable, $idItem, $champRelationship): ResourceCollection
    {

        $list = [];

        switch ($nameTable) {
            case 'Country':
                $list = Country::select("name as title_ar", "name as title_en", 'id')->get();
                break;
            default:
                if ($champRelationship == null) {
                    $list = WfLookups::get();
                } else {
                    $list = WfLookups::where('type_data', $champRelationship)->get();
                }
                
                break;
        }


        return DataSelectResource::collection($list);
    }


}
