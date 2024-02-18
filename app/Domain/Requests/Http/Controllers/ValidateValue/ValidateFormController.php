<?php

namespace App\Domain\Requests\Http\Controllers\ValidateValue;
 


use App\Common\Http\Controllers\Controller; 
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Parameter;

class ValidateFormController extends Controller
{
     

    #[Post(
        path:  '/api/v1/request/validate-form',
        summary:'Validate Form ',
        security: [['sanctum' => []]],
        tags: [ 'Validate Form' ],
        requestBody: new RequestBody(
            description: 'Validate Form',
            required: true,
            content: new JsonContent(
                required: [  'request_type_id' , 'field_name'   ],
                properties: [

                    new Property(
                        property: 'request_type_id',
                        type: 'integer',
                        example: 1,
                    ),
                     
                    new Property(
                        property: 'field',
                        type: [],
                        example: [ "age" => 35],
                    ) 
                   
 

                ],
            ),
        ),
        parameters: [ 
          
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
            ) 
            
        ],
        responses: [
            new \OpenApi\Attributes\Response(
                response: 200,
                description: 'field from  registered successfully',
               
            ),
            new \OpenApi\Attributes\Response(
                response: 400,
                description: 'Bad Request',
            ),
            new \OpenApi\Attributes\Response(
                response: 422,
                description: 'Validation failed',
            ),
        ],
    )]

    public function __invoke(Request $request): JsonResponse
    {
       if($request->request_type_id == 16 ){
        
                $validator = Validator::make($request->field, [
                'meetingNumber' => [ 'integer', 'min:1'] ,
                'classNumber' => [ 'integer', 'min:1'] ,
                ]);

                if ($validator->fails()) {
                // $error = $validator->errors()->first();
                    
                    return response()->json([
                        'errors' => $validator->errors(),
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);

                } 
        }
         return response()->json([
            'errors' => [],
            'status' => Response::HTTP_OK  ,
        ], Response::HTTP_OK );  
    }
}
