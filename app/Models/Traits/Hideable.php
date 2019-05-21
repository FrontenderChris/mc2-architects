<?php

namespace App\Models\Traits;

use App\Scopes\HideableScope;

/**
 * Class Hideable
 * @package App\Models\Traits
 */
trait Hideable
{
    public static function bootHideable()
    {
        static::addGlobalScope(new HideableScope());
    }
}