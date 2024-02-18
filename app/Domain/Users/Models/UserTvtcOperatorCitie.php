<?php

namespace App\Domain\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Requests\Models\RequestDataField;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Requests\Models\TemplateDataField;
use App\Domain\Users\Models\user;
use App\Common\Models\City;

class UserTvtcOperatorCitie extends Model
{
    use HasFactory ;
    use SoftDeletes;


    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tvtc_operator_citie';

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

    protected $fillable = [ 'user_id',  'city_id'  ];


    /**
     * Get the user  for the UserTvtcOperatorCitie .
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city  for the UserTvtcOperatorCitie .
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }






}
