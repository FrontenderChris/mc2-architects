<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class HideableScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return $this
     */
    public function apply(Builder $builder, Model $model)
    {
        if (IS_FRONTEND && Schema::hasColumn($model->getTable(), 'is_enabled') && !\App::runningInConsole())
            return $builder->where('is_enabled', 1);

        return null;
    }
}