<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domain\Requests\Models\FieldType;
use App\Domain\Requests\Models\RequestData;
use App\Domain\Requests\Models\TemplateDataField;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestDataField extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_data_fields';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */

    protected $fillable = [ 'label','label_ar' ,'field_name' ,  'field_value' , 'field_type_id' , 'request_data_id' , 'is_overwritten' , 'template_data_field_id' , 'request_data_field_id' , 'created_at' ,  'updated_at'];



    /**
    * Get the field for the TemplateData .
    *
    */
    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FieldType::class);
    }



    /**
    * Get the TemplateDataField for the TemplateData .
    *
    */
    public function templateDataField(): BelongsTo
    {
        return $this->belongsTo(TemplateDataField::class);
    }


    /**
        * Get the  RequestData for the field .
        *
        */
    public function requestData(): BelongsTo
    {
        return $this->belongsTo(RequestData::class);
    }




}
