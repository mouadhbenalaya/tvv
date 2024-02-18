<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestSteps extends Model
{
    use HasFactory ;
    use SoftDeletes;
    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_stepss';

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
    protected $fillable = [   'created_at' ,  'updated_at' ,    'step_title_en','step_title_ar', 'step_sequence','can_reject', 'can_return' ,'status' ,'request_id'  , 'template_step_id' , 'request_permission_id'  ];




    /**
    * Get the request for the RequestSteps
    *
    */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }



    /**
    * Get the parent templateStep for the RequestSteps
    *
    */
    public function templateStep(): BelongsTo
    {
        return $this->belongsTo(TemplateStep::class);
    }


    /**
       * Get the parent RequestPermission for the RequestSteps
       *
       */
    public function requestPermission(): BelongsTo
    {
        return $this->belongsTo(RequestPermission::class);
    }


    /**
     * Get the requestTransactions Data for the RequestSteps.
     */
    public function requestTransactions(): HasMany
    {
        return $this->hasMany(RequestTransaction::class);
    }

}
