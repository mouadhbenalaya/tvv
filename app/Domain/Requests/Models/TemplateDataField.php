<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Requests\Models\FieldType;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\RequestDataField;

class TemplateDataField extends Model
{
    use HasFactory ;
    use SoftDeletes;

    public $timestamps = true; 

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'template_data_fields';

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

    protected $fillable = [ 'enabled', 'label', 'label_ar' , 'field_name' , 'required' , 'readonly' , 'name_table_relationship' , 'created_at' ,  'updated_at', 'type_data_table_relationship' , 'field_type_id',  'template_data_id' , 'template_data_field_id'];



    /**
    * Get the field for the TemplateData .
    *
    */
    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FieldType::class);
    }

    /**
      * Get the  TemplateData for the field .
      *
      */
    public function templateData(): BelongsTo
    {
        return $this->belongsTo(TemplateData::class);
    }




    /**
    * Get the parent TemplateDataField for the TemplateDataField
    *
    */
    public function templateDataField(): BelongsTo
    {
        return $this->belongsTo(TemplateDataField::class);
    }


    /**
     * Get the child TemplateDataField for the TemplateDataField
     */
    public function templateDataFields(): HasMany
    {
        return $this->hasMany(TemplateDataField::class)->where('enabled', '=', 1);
    }


    /**
     * Get the requestDataFields Data for the Fields .
     */
    public function requestDataFields(): HasMany
    {
        return $this->hasMany(RequestDataField::class);
    }


}
