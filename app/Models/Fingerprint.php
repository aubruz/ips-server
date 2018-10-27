<?php

namespace App\Models\IPS;

use Barryvdh\Reflection\DocBlock\Type\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OptimusTrait;

/**
 * Class Fingerprint
 * @package uKonect\Models\IPS
 *
 * @property-read Collection|WifiSample[] $wifiSamples
 * @property-read Collection|BluetoothSample[] $bluetoothSamples
 * @property-read Collection|MagneticSample[] $magneticSamples
 * @property-read Point $point
 */
class Fingerprint extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * @return HasMany
     */
    public function wifiSamples()
    {
        return $this->hasMany('uKonect\Models\IPS\WifiSample');
    }

    /**
     * @return HasMany
     */
    public function bluetoothSamples()
    {
        return $this->hasMany('uKonect\Models\IPS\BluetoothSample');
    }

    /**
     * @return HasMany
     */
    public function magneticSamples()
    {
        return $this->hasMany('uKonect\Models\IPS\MagneticSample');
    }

    /**
     * @return BelongsTo
     */
    public function point()
    {
        return $this->belongsTo('uKonect\Models\IPS\Point');
    }
}
