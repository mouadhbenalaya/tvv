<?php

namespace App\Common\Models;

use App\Common\Models\Region;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $code_alpha_2
 * @property string $code_alpha_3
 * @property int $code_numeric
 * @property string $name
 */
class Country extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';


    protected $fillable = [
      'code_alpha_2',
      'code_alpha_3',
      'code_numeric',
      'name',
      'name_ar',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
