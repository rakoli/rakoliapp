<?php

namespace App\Models\Scopes;


use App\Models\Location;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LocationScoped implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        if (auth()->check() && auth()->user()->type->AGENT && (! app()->runningInConsole() )) {

            return $builder->whereIn('location_code', Location::query()
                ->whereHas('users', fn($query) => $query->where('user_code', auth()->user()->code))
                ->pluck('code')
                ->toArray()
            );
        }
        return $builder;

    }
}
