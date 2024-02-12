<?php

namespace App\Models\Scopes;


use App\Models\Location;
use App\Utils\Enums\UserStatusEnum;
use App\Utils\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LocationScoped implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        if (auth()->check() && auth()->user()->type == UserTypeEnum::AGENT->value && (! app()->runningInConsole() )) {

            return $builder->whereIn($model->getTable().'.location_code', auth()->user()->loadMissing('locations')->locations->pluck('code')->toArray());
        }
        return $builder;

    }
}
