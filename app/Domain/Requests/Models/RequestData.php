<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\Request;
use App\Domain\Requests\Models\TemplateData;
use App\Domain\Requests\Models\RequestDataField;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestData extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_datas';


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

    protected $fillable = [ 'description',  'title' , 'description_ar',  'title_ar' , 'type_data', 'request_data_id' , 'request_id' , 'template_data_id', 'created_at' ,  'updated_at'  ];

    /**
    * Get the request for the RequestData
    *
    */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    /**
        * Get the parent requestData for the RequestData
        *
        */
    public function requestData(): BelongsTo
    {
        return $this->belongsTo(RequestData::class);
    }



    /**
    * Get the parent TemplateData for the RequestData
    *
    */
    public function templateData(): BelongsTo
    {
        return $this->belongsTo(TemplateData::class);
    }


    /**
     * Get the child TemplateData for the TemplateData
     */
    public function requestDatas(): HasMany
    {
        return $this->hasMany(RequestData::class);
    }


    /**
        * Get the Fields for the Template Data.
        */
    public function requestDataFields(): HasMany
    {
        return $this->hasMany(RequestDataField::class);
    }

}
