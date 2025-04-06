<?php

namespace App\Filters\Admin;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CountryFilter extends QueryFilter
{
    public function available($state = 1): Builder
    {
        return $this->builder->available($state);
    }

    public function search($keyword = ''): Builder
    {
        return $this->builder->search(['name', 'code'], $keyword);
    }
}
