<?php

namespace App\Models\IPS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OptimusTrait;

/**
 * Class Building
 * @package uKonect\Models\IPS
 *
 * @property $name
 * @property $address
 */
class Building extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
    ];

    /**
     * @return HasMany
     */
    public function floors()
    {
        return $this->hasMany('uKonect\Models\IPS\Floor');
    }
}
