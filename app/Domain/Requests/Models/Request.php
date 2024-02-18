<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\RequestData;
use App\Domain\Users\Models\Profile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Common\Models\City;
use App\Domain\Users\Models\UserType ;

class Request extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requests';

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

    protected $fillable = [ 'notes',  'profile_id' , 'request_type_id' , 'created_at' , 'request_status_id'  ,  'updated_at' ,
     'trainee_profile_id' , 'trainer_profile_id' , 'establishmed_id' , 'citie_id'
     ];



    /**
     * Get the traineeProfile for the Request
     *
     */
    public function traineeProfile(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'trainee_profile_id');
    }

    /**
        * Get the trainerProfile for the Request
        *
        */
    public function trainerProfile(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'trainer_profile_id');
    }


    /**
        * Get the establishmed for the Request
        *
        */
    public function establishmed(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'establishmed_id');
    }



    /**
     * Get the requestStatus for the Request
     *
     */
    public function requestStatus(): BelongsTo
    {
        return $this->belongsTo(RequestStatus::class);
    }


    /**
     * Get the city for the Request
     *
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'citie_id');
    }


    /**
        * Get the profile for the Request
        *
        */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
    * Get the RequestType for the Request
    *
    */
    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }



    /**
     * Get the Template Data for the Request.
     */
    public function requestDatas(): HasMany
    {
        return $this->hasMany(RequestData::class);
    }


    /**
     * Get the requestStepss Data for the Request.
     */
    public function requestStepss(): HasMany
    {
        return $this->hasMany(RequestSteps::class);
    }



    /**
     * Get the requestTransactions Data for the Request.
     */
    public function requestTransactions(): HasMany
    {
        return $this->hasMany(RequestTransaction::class);
    }


}
