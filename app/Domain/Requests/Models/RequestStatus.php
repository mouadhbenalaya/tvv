<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Requests\Models\TemplateDataField;

class RequestStatus extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_statuss';

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

    protected $fillable = [ 'title_ar',  'title_en' , 'created_at' , 'code_color' ,  'updated_at' ];




    /**
     * Get the child requests for the RequestStatus
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }


}
