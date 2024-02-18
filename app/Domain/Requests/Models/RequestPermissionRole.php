<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestPermission;
use App\Domain\Users\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestPermissionRole extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_permission_role';

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

    protected $fillable = [ 'request_permission_id' , 'role_id'  , 'created_at' ,  'updated_at' ];



    /**
     * Get the requestPermission for the RequestPermissionRole .
     *
     */
    public function requestPermission(): BelongsTo
    {
        return $this->belongsTo(RequestPermission::class);
    }

    /**
     * Get the role for the RequestPermissionRole .
     *
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }




}
