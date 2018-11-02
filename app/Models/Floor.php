<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Traits\OptimusTrait;

/**
 * Class Floor
 * @package uKonect\Models\IPS
 *
 * @property $name
 * @property $blueprint
 * @property $width
 * @property $height
 * @property-read Collection|Fingerprint[] $fingerprints
 * @property-read Building $building
 */
class Floor extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'blueprint',
        'width',
        'height',
    ];

    /**
     * @return HasMany
     */
    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }

    /**
     * @return BelongsTo
     */
    public function building()
    {
        return $this->belongsTo('App\Models\Building');
    }

    /**
     * @return HasManyThrough
     */
    public function fingerprints()
    {
        return $this->hasManyThrough('App\Models\Fingerprint', 'App\Models\Point');
    }
}
