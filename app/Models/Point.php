<?php

namespace App\Models\IPS;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\OptimusTrait;

/**
 * Class Point
 * @package uKonect\Models\IPS
 *
 * @property $location
 * @property $name
 * @property $x
 * @property $y
 * @property-read Collection|Fingerprint[] $fingerprints
 * @property-read Floor $floor
 */
class Point extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'x',
        'y',
        'location',
    ];

    /**
     * @return HasMany
     */
    public function fingerprints()
    {
        return $this->hasMany('App\Models\Fingerprint');
    }

    /**
     * @return BelongsTo
     */
    public function floor()
    {
        return $this->belongsTo('App\Models\Floor');
    }
}
