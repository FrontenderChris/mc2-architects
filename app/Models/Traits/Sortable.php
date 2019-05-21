<?php

namespace App\Models\Traits;

use App\Scopes\SortableScope;

/**
 * Class Sortable
 * @package App\Models\Traits
 */
trait Sortable
{
    public static function bootSortable()
    {
        static::addGlobalScope(new SortableScope);
    }
}