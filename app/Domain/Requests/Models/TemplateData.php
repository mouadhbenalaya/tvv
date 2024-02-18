<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\TemplateDataField;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateData extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'template_datas';

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
    protected $fillable = [   'enabled', 'description','title' , 'description_ar',  'title_ar', 'type_data' ,'template_data_id' ,'request_type_id' , 'created_at' ,  'updated_at' ];


    /**
    * Get the RequestType for the TemplateData
    *
    */
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }


    /**
    * Get the parent TemplateData for the TemplateData
    *
    */
    public function templateData(): BelongsTo
    {
        return $this->belongsTo(TemplateData::class);
    }


    /**
     * Get the child TemplateData for the TemplateData
     */
    public function templateDatas(): HasMany
    {
        return $this->hasMany(TemplateData::class);
    }


    /**
     * Get the child requestDatas for the TemplateData
     */
    public function requestDatas(): HasMany
    {
        return $this->hasMany(RequestData::class);
    }

    /**
        * Get the Fields for the Template Data.
        */
    public function templateDataFields(): HasMany
    {
        return $this->hasMany(TemplateDataField::class)->where('enabled', '=', 1);
    }

}
