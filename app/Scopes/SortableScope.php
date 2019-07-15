<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SortableScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return $this
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->orderBy(\DB::raw('sort_order'), 'asc');
    }
}