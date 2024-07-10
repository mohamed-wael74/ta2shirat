<?php

namespace App\Filters\Website;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CountryFilter extends QueryFilter
{
    public function search($keyword = ''): Builder
    {
        return $this->builder->search(['name', 'code'], $keyword);
    }
}
