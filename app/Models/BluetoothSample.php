<?php

namespace App\Models\IPS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\OptimusTrait;

/**
 * Class BluetoothSample
 * @package uKonect\Models\IPS
 *
 * @property $uuid
 * @property $major
 * @property $minor
 * @property $rssi
 * @property-read Fingerprint $fingerprint
 */
class BluetoothSample extends Model
{
    use OptimusTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'major',
        'minor',
        'rssi',
    ];

    /**
     * @return BelongsTo
     */
    public function fingerprint()
    {
        return $this->belongsTo('App\Models\IPS\Fingerprints');
    }
}
