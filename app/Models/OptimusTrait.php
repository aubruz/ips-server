<?php

namespace App\Models;

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
