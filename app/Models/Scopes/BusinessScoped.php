<?php

namespace App\Models\Scopes;

use App\Models\Business;
use App\Models\Location;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BusinessScoped implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->user()->type == UserTypeEnum::AGENT)
        {
            $builder->where('Business_Code', auth()->user()->Business_Code);
        }
    }
}
