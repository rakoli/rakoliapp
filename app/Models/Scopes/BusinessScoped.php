<?php

namespace App\Models\Scopes;

use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BusinessScoped implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): Builder
    {
        if (auth()->user() != null && auth()->user()->type == UserTypeEnum::AGENT->value) {
            return $builder->where('business_code', auth()->user()->business_code);
        }

        return $builder;
    }
}
