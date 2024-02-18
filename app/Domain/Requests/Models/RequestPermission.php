<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\TemplateStep;
use App\Domain\Requests\Models\RequestPermissionRole;
use App\Domain\Users\Models\UserType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPermission extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_permissions';

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

    protected $fillable = [ 'title_ar' , 'title_en' , 'enabled' , 'user_type_id', 'created_at' ,  'updated_at'];



    /**
    * Get the userType for the RequestPermission
    *
    */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }


    /**
     * Get the templateSteps for the RequestPermission.
     */
    public function templateSteps(): HasMany
    {
        return $this->hasMany(TemplateStep::class) ;
    }



    /**
     * Get the RequestPermissionRole for the RequestPermission.
     */
    public function requestPermissionRoles(): HasMany
    {
        return $this->hasMany(RequestPermissionRole::class) ;
    }


    /**
     * Get the requestStepss Data for the RequestPermission.
     */
    public function requestStepss(): HasMany
    {
        return $this->hasMany(RequestSteps::class);
    }


}
