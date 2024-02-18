<?php

namespace App\Domain\Requests\Models;

use App\Domain\Users\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestTransaction extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_transactions';

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

    protected $fillable = [ 'request_steps_id',  'request_id' , 'profile_id' , 'step_action_id' , 'note' , 'created_at',    'updated_at' ];



    /**
      * Get the requestSteps for the RequestTransaction
      *
      */
    public function requestSteps(): BelongsTo
    {
        return $this->belongsTo(RequestSteps::class);
    }



    /**
      * Get the request for the RequestTransaction
      *
      */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }


    /**
      * Get the requestSteps for the RequestTransaction
      *
      */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


    /**
      * Get the requestSteps for the RequestTransaction
      *
      */
    public function stepAction(): BelongsTo
    {
        return $this->belongsTo(StepAction::class);
    }


}
