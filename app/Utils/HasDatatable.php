<?php

namespace App\Utils;

use Yajra\DataTables\Html\Builder;

interface HasDatatable
{
    public function columns(Builder $datatableBuilder): Builder;
}
