<?php

namespace App\Models\IPS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\OptimusTrait;

/**
 * Class WifiSample
 * @package uKonect\Models\IPS
 *
 * @property $bssid
 * @property $rssi
 * @property-read Fingerprint $fingerprint
 */
class MagneticSample extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'x',
        'y',
        'z',
        'north',
        'sky',
    ];

    /**
     * @return BelongsTo
     */
    public function fingerprint()
    {
        return $this->belongsTo('App\Models\Fingerprints');
    }
}
