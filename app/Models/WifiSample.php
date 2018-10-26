<?php

namespace App\Models\IPS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OptimusTrait;

/**
 * Class WifiSample
 * @package uKonect\Models\IPS
 *
 * @property $bssid
 * @property $rssi
 * @property-read Fingerprint $fingerprint
 */
class WifiSample extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bssid',
        'rssi',
    ];

    /**
     * @return BelongsTo
     */
    public function fingerprint()
    {
        return $this->belongsTo('uKonect\Models\IPS\Fingerprints');
    }
}
