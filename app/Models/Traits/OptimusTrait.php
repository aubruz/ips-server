<?php

namespace App\Models\Traits;

trait OptimusTrait
{
    /**
     * @return int
     */
    public function getEncodedIdAttribute()
    {
        /* @noinspection PhpUndefinedFieldInspection */
        return optimus_encode($this->id);
    }
}
