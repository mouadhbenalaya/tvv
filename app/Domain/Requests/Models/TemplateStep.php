<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\RequestPermission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateStep extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'template_steps';

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

    protected $fillable = [ 'request_permission_id',  'request_type_id' , 'created_at' ,  'updated_at' , 'step_sequence' , 'step_title_ar', 'step_title_en' , 'can_reject' , 'can_return' ];



    /**
    * Get the RequestType for the TemplateStep
    *
    */
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    /**
    * Get the role for the TemplateStep
    *
    */
    public function requestPermission(): BelongsTo
    {
        return $this->belongsTo(RequestPermission::class);
    }


    /**
     * Get the requestStepss Data for the TemplateStep.
     */
    public function requestStepss(): HasMany
    {
        return $this->hasMany(RequestSteps::class);
    }




}
