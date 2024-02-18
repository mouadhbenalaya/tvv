<?php

namespace App\Domain\Requests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestDataField;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Requests\Models\TemplateDataField;

class FieldType extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'field_types';

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

    protected $fillable = [ 'enabled',  'name' ,  'class', 'type_field'  , 'name_table_relationship' , 'created_at' ,  'updated_at' , 'name_field' ];


    /**
     * Get the Template Data for the Fields .
     */
    public function templateDataFields(): HasMany
    {
        return $this->hasMany(TemplateDataField::class)->where('enabled', '=', 1);
    }



    /**
     * Get the requestDataFields Data for the Fields .
     */
    public function requestDataFields(): HasMany
    {
        return $this->hasMany(RequestDataField::class);
    }




}
