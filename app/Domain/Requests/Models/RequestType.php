<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\RequestCategory;
use App\Domain\Requests\Models\TemplateStep;
use App\Domain\Requests\Models\Request;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestType extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_types';

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

    protected $fillable = [ 'enabled',  'title' , 'validator' ,'title_ar' , 'link_get_data' ,'desc_short_ar' ,'desc_short_en' ,'desc_long_ar' ,'desc_long_en' , 'release_version' , 'request_category_id' , 'release_date' , 'request_type_id' , 'created_at' ,  'updated_at' ];



    /**
     * Get the Template Data for the RequestType.
     */
    public function templateSteps(): HasMany
    {
        return $this->hasMany(TemplateStep::class) ;
    }


    /**
     * Get the Template Data for the RequestType.
     */
    public function templateStepsOne(): HasMany
    {
        return $this->hasMany(TemplateStep::class)->where('step_sequence', 1) ;
    }


    /**
         * Get the Template Data for the RequestType.
         */
    public function templateDatas(): HasMany
    {
        return $this->hasMany(TemplateData::class)->where('template_data_id', '=', null)->where("enabled", 1);
    }



    /**
     * Get the Template Data for the RequestType.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class) ;
    }



    /**
     * Get the RequestType for the RequestType.
     */
    public function requestTypes(): HasMany
    {
        return $this->hasMany(RequestType::class) ;
    }


    /**
    * Get the requestType for the requestType
    *
    */
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    /**
    * Get the requestType for the requestType
    *
    */
    public function requestCategory(): BelongsTo
    {
        return $this->belongsTo(RequestCategory::class);
    }

}
