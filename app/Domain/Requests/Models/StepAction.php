<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StepAction extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'step_actions';

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

    protected $fillable = [ 'title_ar',  'title_en' , 'code_color', 'created_at' ,  'updated_at' ];


    /**
     * Get the requestTransactions Data for the StepAction.
     */
    public function requestTransactions(): HasMany
    {
        return $this->hasMany(RequestTransaction::class);
    }
}
