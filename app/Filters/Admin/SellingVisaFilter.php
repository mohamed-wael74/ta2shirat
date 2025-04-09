<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class SellingVisaFilter extends QueryFilter
{
    public function done($state = 'yes'): Builder
    {
        return \in_array($state, \array_keys($this->availableBooleanValues)) ? $this->builder->done($this->availableBooleanValues[$state]) : $this->builder;
    }
}
