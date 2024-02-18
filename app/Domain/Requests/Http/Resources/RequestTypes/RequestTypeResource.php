<?php

declare(strict_types=1);

namespace App\Domain\Requests\Http\Resources\RequestTypes;

use App\Domain\Requests\Http\Controllers\Request\GetDataSelectByIdController;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use App\Domain\Requests\Services\GetDataSelectService;

/**
 * Class RequestTypeResource.
 *
 * @property int $id
 * @property string $title
 * @property boolean $enabled
 */
#[Schema(
    title: 'RequestType resource',
    description: 'RequestType resource',
    properties: [
        new Property(
            property: 'id',
            type: 'integer',
            default: 1,
        ),
        new Property(
            property: 'enabled',
            type: 'boolean',
            default: 1,
        ),
        new Property(
            property: 'title',
            type: 'string',
        ),
        new Property(
            property: 'release_version',
            type: 'string',
        ),
        new Property(
            property: 'release_date',
            type: 'date',
        ),

    ],
    type: 'object'
)]
class RequestTypeResource extends JsonResource
{
    /**
     * @param mixed $request
     */
    public function toArray($request): array
    {

        $result = [] ;

        foreach($this->templateDatas as $templateData) {

            $formSchema = [] ;
            $properties = [] ;
            $uiSchema = [] ;
            $requiredField = [] ;
            $enum = []  ;
            $enumSelect = []  ;
            $resultFormData = [];

            /** get default data for this request type */
            $defaultData = [
                'testCheckbox' => [  1   ] ,
                'isFemaleTraining' => [  6, 8  ] ,
                'toDate' => "2024-01-24" ,
                'programDescription' => "Test Data" ,
                "fullName2" => "test2",
                ] ;
            /** get info by Id request Type  */

            if($templateData->enabled == 1) {
                $entities = $templateData->templateDataFields ;
                $entities = $entities-> sortByDesc('field_name')  ;
                $title = "titleBlock".$templateData->id ;

                $oldFieldName =   null ;
                foreach($entities as $key => $value) {
                    if($oldFieldName    == null) {
                        $oldFieldName =  $value->field_name ;
                    }

                    if($oldFieldName != $value->field_name) {
                        $enum = []  ;
                        $enumSelect = [] ;
                        $oneOf  = [];
                        $oldFieldName =  $value->field_name ;
                    }
                    /** block fill formData array */
                    if(array_key_exists($value->field_name, $defaultData)) {
                        $resultFormDatanew[$title][$value->field_name] = $defaultData[$value->field_name] ;
                        $resultFormData =  array_merge($resultFormData, $resultFormDatanew) ;
                    }

                    /** Structure json for type radio */
                    if($value->fieldType->name_field == "radio") {

                        if(!empty($value->name_table_relationship)) {

                            $getDataSelectServices = new GetDataSelectService() ;

                            $entities =  $getDataSelectServices->getDatas($value->name_table_relationship, null, $value->type_data_table_relationship);


                            $oneOf  = [];

                            if(!empty($entities)) {
                                foreach($entities as $index => $item) {

                                    $oneOf[$index ] = [
                                        "const" =>  $item ->id,
                                        "title" =>   (\App::getLocale() == 'ar') ? $item->title_ar : $item->title_en  ,

                                    ] ;
                                }

                                if( !empty($value->template_data_field_id)){
                                    $properties[$value->field_name] = [
                                            'name_current_field' => $value->field_name,           // name of current field
                                            'name_table_relationship' => $value->templateDataField->name_table_relationship,           // name of the db table will get the list for the child.
                                            'name_target_field' => $value->templateDataField->field_name  ,             // name of the target
                                            'name_target_field_required' => $value->required == 1 ? 'true' :'false',       // is the child required
                                            'name_target_field_title' =>  (\App::getLocale() == 'ar') ? $value->templateDataField->label_ar : $value->templateDataField->label,       // child title
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship' : NULL ,                    // custom widget
                                            'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                            'type' => $value->fieldType->type_field,
                                            'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label , 
                                            "oneOf" => $oneOf
                                        ];
    
                                }
                                else{
                                    $properties[$value->field_name] = [ 
                                        'type' => $value->fieldType->type_field,
                                        'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                        'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                        'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                                        'name_table_relationship' => $value->name_table_relationship,           // name of the db table will get the list for the child.
                                        "oneOf" => $oneOf
                                    ];                  
                                
                                } 
                            }

                        }
                    }

                    /** Structure json for type Single checkbox */
                    elseif($value->fieldType->name == "Single checkboxes") {

                        $enum[0] = [
                            "const" =>   1 ,
                            "title" =>   (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                        ] ;




                        if( !empty($value->template_data_field_id)){
                            $properties[$value->field_name] = [
                                    'name_current_field' => $value->field_name,           // name of current field
                                    'name_table_relationship' => $value->templateDataField->name_table_relationship,           // name of the db table will get the list for the child.
                                            'name_target_field' => $value->templateDataField->field_name  ,             // name of the target
                                    'name_target_field_required' => $value->required == 1 ? 'true' :'false',       // is the child required
                                    'name_target_field_title' =>  (\App::getLocale() == 'ar') ? $value->templateDataField->label_ar : $value->templateDataField->label,       // child title
                                    'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL  ,                    // custom widget
                                    'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                    'type' => $value->fieldType->type_field,
                                    'title' => ' ',
                                    "items" => [
                                        "type" => "number",
                                        "anyOf" => $enum
                                      ] ,
                                    "uniqueItems" => true
                                ];

                        }
                        else{
                            $properties[$value->field_name] = [ 
                                'type' => $value->fieldType->type_field,
                                'title' => ' ',
                                'name_table_relationship' => $value->name_table_relationship,           // name of the db table will get the list for the child.
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                'validate' => ($value->name_table_relationship == "custom_validation") ?'true' :'false',                    // custom widget
                                "items" => [
                                    "type" => "number",
                                    "anyOf" => $enum
                                  ] ,
                                "uniqueItems" => true
                            ];                  
                        
                        }
                    }


                    /** Structure json for type checkbox */
                    elseif($value->fieldType->name_field == "checkboxes") {

                        $getDataSelectServices = new GetDataSelectService() ;

                        $entities =  $getDataSelectServices->getDatas($value->name_table_relationship, null, $value->type_data_table_relationship);

                        if(!empty($entities)) {
                                foreach($entities as $index => $item) {
                                    $enum[$index ] = [
                                        "const" =>  $item ->id,
                                        "title" =>   (\App::getLocale() == 'ar') ? $item->title_ar : $item->title_en  ,

                                    ] ;

                                }

                                if( !empty($value->template_data_field_id)){
                                    $properties[$value->field_name] = [
                                            'name_current_field' => $value->field_name,           // name of current field
                                            'name_table_relationship' => $value->templateDataField->name_table_relationship,           // name of the db table will get the list for the child.
                                            'name_target_field' => $value->templateDataField->field_name  ,             // name of the target
                                            'name_target_field_required' => $value->required == 1 ? 'true' :'false',       // is the child required
                                            'name_target_field_title' =>  (\App::getLocale() == 'ar') ? $value->templateDataField->label_ar : $value->templateDataField->label,       // child title
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                            'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                            'type' => $value->fieldType->type_field,
                                            'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label , 
                                            "items" => [
                                                "type" => "number",
                                                "anyOf" => $enum
                                            ] ,
                                            "uniqueItems" => true
                                        ];

                                }
                                else{
                                    $properties[$value->field_name] = [ 
                                        'type' => $value->fieldType->type_field,
                                        'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                                        'name_table_relationship' => $value->name_table_relationship,           // name of the db table will get the list for the child.
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                        'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                        "items" => [
                                            "type" => "number",
                                            "anyOf" => $enum
                                        ] ,
                                        "uniqueItems" => true
                                    ];                  
                                
                                }                             
 
                        }
                    }

                    /** Structure json for type select */
                    elseif($value->fieldType->name_field == "select") {
                        $enumSelect = []  ;

                        if(!empty($value->name_table_relationship)) {
                            // get data select  
                            $getDataSelectServices = new GetDataSelectService() ;

                            $entities =  $getDataSelectServices->getDatas($value->name_table_relationship, null, $value->type_data_table_relationship);

                            if(!empty($entities)) {
                                $valueSelect = null ;
                                foreach($entities as $index => $item) {

                                    $enumSelect[$index ] = [
                                        "const" =>  $item ->id,
                                        "title" =>   (\App::getLocale() == 'ar') ? $item->title_ar : $item->title_en  ,

                                    ] ;
                                    if(empty($valueSelect)) {
                                        $valueSelect = $item->id ;
                                    }

                                }
                                if( !empty($value->template_data_field_id)){
                                    $properties[$value->field_name] = [
                                            'name_current_field' => $value->field_name,           // name of current field
                                            'name_table_relationship' => $value->templateDataField->name_table_relationship,           // name of the db table will get the list for the child.
                                            'name_target_field' => $value->templateDataField->field_name  ,             // name of the target
                                            'name_target_field_required' => $value->required == 1 ? 'true' :'false',       // is the child required
                                            'name_target_field_title' =>  (\App::getLocale() == 'ar') ? $value->templateDataField->label_ar : $value->templateDataField->label,       // child title
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                            'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                            'type' => $value->fieldType->type_field,
                                            'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label , 
                                            "oneOf" => $enumSelect ,// ['كرة القدم' , 'كرة اليد'  , 'موسيقى']
                                          
                                        ];
    
                                }
                                else{
                                        $properties[$value->field_name] = [ 
                                            'type' => $value->fieldType->type_field,
                                            'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                                            'name_table_relationship' => $value->name_table_relationship,
                                            'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                                            'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                                            "oneOf" => $enumSelect ,// ['كرة القدم' , 'كرة اليد'  , 'موسيقى']
                                        
                                        ];                      
                                    }
                                }
                        }
                    }

                    /** Structure json for other type  */
                    elseif($value->fieldType->name_field == "date") {
                        $properties[$value->field_name] = [ 
                            'type' => $value->fieldType->type_field, 
                            'format' => 'date',                    // custom widget
                            'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                            'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                            'name_table_relationship' => $value->name_table_relationship,

                        ];
                    }
                    /** Structure json for other type  */
                    else {
                        $properties[$value->field_name] = [ 
                              'type' => $value->fieldType->type_field,
                              'title' =>  (\App::getLocale() == 'ar') ? $value->label_ar : $value->label ,
                              'format' => ( !empty($value->template_data_field_id)) ?  'relationship'  : NULL ,                    // custom widget
                              'validate' => ($value->name_table_relationship == "custom_validation") ? 'true' :'false',                    // custom widget
                              'name_table_relationship' => $value->name_table_relationship,

                          ];
                    }

                    $uiSchema[$value->field_name] = [
                        'ui:widget' => $value->fieldType->name_field,
                        "ui:readonly"  =>  ($value->readonly == 1) ? true : false
                    ] ;

                    if($value->required == 1) {

                        array_push($requiredField, $value->field_name);
                    }



                }
                /**  structure json response */
                $result[ $title] =   [
                    "type"  => "object",
                    "title"  =>  (\App::getLocale() == 'ar') ? $templateData->title_ar : $templateData->title,
                    'description' =>  (\App::getLocale() == 'ar') ? $templateData->description_ar : $templateData->description  ,
                     'required' => $requiredField ,
                    "type"  => "object",
                    'properties' => $properties ,
                ] ;
                $resultUiSchema[ $title] =   $uiSchema ;
            }

        }

        $formSchema = [
            'id' => $this->id,
            'title' => (\App::getLocale() == 'ar') ? $this->title_ar : $this->title  ,

          //  'User_type' =>  $typeUser->getUserType(),
          'release_version' => $this->release_version   ,
          'validator' => $this->validator   ,
          'release_date' => $this->release_date   ,
            'type' => "object"  ,
            'properties' =>    $result  ,
        ];

        return [
            'formSchema' =>  $formSchema,
            'uiSchema' => $resultUiSchema ,
            'formData' => $resultFormData
        ];
    }
}
