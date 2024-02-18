<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestType;
use App\Domain\Requests\Models\Request;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestCategory extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_categorys';

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

    protected $fillable = [ 'title_ar' , 'title_en' , 'created_at' ,  'updated_at', 'enabled' ];



    /**
     * Get the Template Data for the RequestType.
     */
    public function requestTypes(): HasMany
    {
        return $this->hasMany(RequestType::class) ;
    }



}
